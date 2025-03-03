<?php

namespace App\Http\Controllers;

use App\Models\Admins;
use App\Models\Dates;
use App\Models\InkrementAufrufe;
use App\Models\Mitarbeiter;
use App\Models\Newsletter;
use App\Models\SendingEmails;
use App\Models\Termine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class MainController extends BaseController
{
    public function getHome()
    {
        $inkrem = new InkrementAufrufe();
        return view('mainPageView');
    }

    public function getAboutUs()
    {
        return view('aboutUs');
    }

    public function getImpressum()
    {
        return view('impressumView');
    }

    public function getDatenschutz()
    {
        return view('datenschutzView');
    }

    public function getHilfe()
    {
        return view('hilfeView');
    }

    public function getSozio()
    {
        return view('sozioView');
    }

    public function getTeam()
    {
        try{
            $mitarbeiter = mitarbeiter::query()->select('*')->get();
        }
        catch(\Exception $e){
            Session::flash("error_db", $e->getMessage());
        }
        return view('teamView', ['data' => $mitarbeiter]);
    }

    public function getTermine()
    {
        try {
            // Termine aus der Datenbank holen und direkt sortieren
            $termine = Termine::query()->orderBy('datum')->get();

            // Aktuelles Datum als Carbon-Instanz holen
            $currentDate = Carbon::now('Europe/Berlin');

            foreach ($termine as $termineDatum) {
                // Datum des Termins als Carbon-Objekt parsen
                $termin = Carbon::parse($termineDatum->datum);

                // Falls der Termin in der Vergangenheit liegt, löschen
                if ($termin->lt($currentDate)) {
                    Termine::query()->where('datum', $termineDatum->datum)->delete();
                }
            }

        } catch (\Exception $e) {
            Session::flash("error", $e->getMessage());
        }

        // View mit den Terminen zurückgeben
        return view('termineView', ['data' => $termine]);
    }

    public function getBetreutes()
    {
        return view('betreutesView');
    }


    public function getKontakt()
    {
        return view('contactView');

    }

    public function getJobs()
    {
        return view('jobsView');
    }

    public function getKoor()
    {
        return view('koorView');
    }

    public function getLogin()
    {

        if(Session::has('admin')){
            if(Session::get("admin")===true){
                return redirect("Verwaltung");
            }
        }
        return view('loginView');
    }

    /**
     * @param Request $request Formular Parameter
     * Verifizierung des Admins.
     */
    public function verifizierung(Request $request)
    {

        if(Session::has('admin')){
            if(Session::get("admin")===true){
                return redirect("Verwaltung");
            }
        }

        // Überprüfung, ob die Felder vorhanden sind
        if ($request->has('name') && $request->has('password')) {
            $name_input = $request->input('name');
            $password_input = $request->input('password');

            // Suche nach Benutzer in der Datenbank
            $admin = Admins::where('user_name', $name_input)->first();

            if ($admin) {
                $pw_input_to_hash = hash('sha256', $password_input . $admin->salt);

                // Login erfolgreich
                if ($pw_input_to_hash === $admin->pw) {
                    Session::put('admin', true);
                    return redirect("Verwaltung");
                }
            }

            // Fehlernachricht bei falschen Anmeldedaten
            Session::flash('msg', 'Benutzername oder Passwort falsch!');
        }

        return view('loginView');
    }


    public function getVerwaltung()
    {
        $aufrufe= null;
        try{
            $aufrufe = Dates::query()->select("aufrufe")->get();
        }catch(\Exception $e){
            Session::flash("error_db", $e->getMessage());
        }

        if(!Session::has('admin')===true){
            return redirect("Admin");
        }

        return view("verwaltungView" , ['data' => $aufrufe] );
    }


    public function getÜbersicht()
    {
        if(!Session::has('admin')){
            return redirect("Admin");
        }

        try{
            $termine = Termine::query()->select('*')->get();
            $data = Mitarbeiter::query()->select('*')->get();
            $email = Newsletter::query()->select('*')->get();
        }catch (\Exception $e){
            Session::flash("error", $e->getMessage());
        }

        return view("useroverview", [
            'data' => $data,
            'data_2' => $email,
            'data_3' => $termine
        ]);
    }

    /**
     * @param Request $request
     * Händelt das Einfügen von Mitarbeiter und das Einfügen vom Veranstaltungen
     * sowie das Versenden von E-Mails, an den Abonnenten des Newsletters.
     */
    public function insertVerwaltung(Request $request)
    {

        if(!Session::has('admin')===true){
            return redirect("Admin");
        }

        if ($request->input("form_name") === "form1") {

            if ($request->has("name") && $request->has("position")) {
                $name = $request->get("name");
                $position = $request->get("position");
                $text = $request->get("text") ?: null;
                $bild = $request->get("bild") ?: null;
                $telefon = $request->get("telefon") ?: null;
                $email = $request->get("email") ?: null;

                try {
                    Mitarbeiter::query()->insert([
                        'name' => $name,
                        'position' => $position,
                        'text' => $text,
                        'bildUrl' => $bild,
                        'telefon' => $telefon,
                        'email' => $email
                    ]);

                    Session::flash("msg", "Mitarbeiter erfolgreich eingefügt.");

                } catch (\Exception $exception) {
                    Session::flash("error", "Fehler beim Einfügen: " . $exception->getMessage());
                }

            } else {
                Session::flash("error", "Fehlercode 0x1: Name und Position erforderlich.");
            }
            return redirect()->to(route('Verwaltung') . '#form1');
        }

        /**
         * Veranstaltungen einfügen mit versenden von E-Mails
         */
        if ($request->input("form_name_2") === "form2") {

            if ($request->has("veranstaltung") && $request->has("datum")) {
                $veranstaltung = $request->get("veranstaltung");
                $datum = $request->get("datum");
                if($request->has("text")){
                    $text = nl2br($request->input('text'), false);
                }else{
                    $text = null;
                }
                $bild = null;
                if($request->file()!=null){
                    $path = Storage::putFile('/public/images', $request->file('bild'));
                    $path = "/storage/images/".basename($path);
                    $bild=$path;

                }

                try {
                    Termine::query()->insert([
                        'veranstaltung' => $veranstaltung,
                        'datum' => $datum,
                        'text' => $text,
                        'bildUrl' => $bild,
                    ]);
                    Session::flash("msg_2", "Aktuelles eingepflegt!.");
                } catch (\Exception $exception) {
                    Session::flash("error_2", $exception->getMessage());
                }

                $send = new SendingEmails();

                if ($send->send($datum, $text)) {
                    Session::flash("msg_email", "Die E-Mails wurden erfolgreich gesendet.");
                } else {
                    Session::flash("error_email", "Fehler beim Senden der E-Mails. Bitte überprüfen Sie die Logs.");
                }


            }
        } else {
            Session::flash("error_2", "Fehlercode 0x3: Fehler beim Einfügen .");
        }
      return redirect()->to(route('Verwaltung') . '#form2');
    }

    /**
     * Methode zum Löschen von Mitarbeitern.
     * Das Löschen wird mit der ID des Mitarbeiters vorgenommen.
     * @param Request $request Formular Parameter
     */
    public function deleteUser(Request $request)
    {

        if(!Session::has('admin')===true){
            return redirect("Admin");
        }


        if ($request->input("form1")==1) {
            $id = $request->input('id');
            try {
                $deletedRows = Mitarbeiter::query()->where('id', $id)->delete();
                if ($deletedRows) {
                    Session::flash("msg_1", "Mitarbeiter erfolgreich gelöscht.");
                } else {
                    Session::flash("error_1", "Kein Mitarbeiter mit der angegebenen ID gefunden.");
                }
            } catch (\Exception $exception) {
                Session::flash("error_1", "Fehler beim Löschen: " . $exception->getMessage());
            }
            return redirect()->to(route('Übersicht') . '#formDelete');
        }

        if ($request->input("form2")==2) {
            $name = $request->input('name');

            try {
                $deletedRows = Newsletter::query()->where('name', $name)->delete();
                if ($deletedRows) {
                    Session::flash("msg_2", "Abonnent erfolgreich gelöscht.");
                } else {
                    Session::flash("error_2", "Kein Abonnent gefunden.");
                }
            } catch (\Exception $exception) {
                Session::flash("error_2", "Fehler beim Löschen: " . $exception->getMessage());
            }
           return redirect()->to(route('Übersicht') . '#formDelete2');
        }

        if ($request->input("form3")==3) {
            $veranstaltung = $request->input('veranstaltung');

            try {
                $deletedRows = Termine::query()->where('veranstaltung', $veranstaltung)->delete();
                if ($deletedRows) {
                    Session::flash("msg_3", "Veranstaltung erfolgreich gelöscht.");
                } else {
                    Session::flash("error_3", "Keine Veranstaltung gefunden.");
                }
            } catch (\Exception $exception) {
                Session::flash("error_3", "Fehler beim Löschen: " . $exception->getMessage());
            }
            return redirect()->to(route('Übersicht') . '#formDelete3');
        }
        return  redirect()->back();
    }

    /**
     *  @param Request $request Formular Parameter
     *  Fügt die Daten des Newsletters in die Datenbank ein.
     */
    public function insertNewsletter(Request $request)
    {

        try {
            $request->validate([
                'email' => 'required|email',
            ]);


            if ($request->has("name") && $request->has("email")) {
                $name = $request->input('name');
                $email = $request->input('email');

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return back()->with('error', 'Ungültige E-Mail-Adresse!');
                }

                Newsletter::query()->insert([
                    'email' => $email,
                    'name' => $name,
                    'consent_given_at' => now()
                ]);

                Session::flash("msg", "Newsletter erfolgreich angelegt.");

            }

        } catch (\Exception $e) {
            Session::flash("error", "E-Mail schon vorhanden oder Fehlercode 0x4");
            return redirect()->to(route('Kontakt') . '#formNews');
        }

        return redirect()->to(route('Kontakt') . '#formNews');
    }


    /**
     * @param Request $request Formular Parameter
     * Sendet eine Emails an den Betreiber
     * Überprüft ob es ein Bot gab, mit einem Hidden-Feld
     */
    public function sendKontakt(Request $request)
    {

             if ($request->filled('website')) {
                 return back()->with('error_kontakt', 'Bot erkannt!');
             }

             if ($request->has("name") && $request->has("email") && $request->has("text")) {
                 $name = $request->input('name');
                 $email = $request->input('email');
                 $text = $request->input('text');

                 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                     return back()->with('error_kontakt', 'Ungültige E-Mail-Adresse!');
                 }
                 if (preg_match('/http:\/\/|https:\/\/|www\./i', $text)) {
                     return back()->with('error_kontakt', 'Links sind im Kontaktformular nicht erlaubt.');
                 }
                 $spamWords = ['buy', 'cheap', 'free', 'winner', 'lottery', 'bitcoin', 'casino', 'viagra'];
                 foreach ($spamWords as $word) {
                     if (stripos($text, $word) !== false) {
                         return back()->with('error_kontakt', 'Verdächtige Nachricht erkannt.');
                     }
                 }


                /*
                 * ÜBERPRÜFUNG DAS TOKENS!
                 * */
                 $secretKey = env('RECAPTCHA_SECRET_KEY');
                 $response = $request->input('g-recaptcha-response'); // Stelle sicher, dass das reCAPTCHA-Token korrekt übermittelt wird

                // Überprüfe, ob der reCAPTCHA-Token vorhanden ist
                 if (empty($response)) {
                     Session::flash("error_kontakt", "reCAPTCHA ungültig");
                     return redirect()->to(route('Kontakt') . '#formKontakt');
                 }

                 $url = 'https://www.google.com/recaptcha/api/siteverify';
                 $data = [
                     'secret' => $secretKey,
                     'response' => $response,
                 ];

                 // HTTP-Anfrage an Google senden
                 $options = [
                     'http' => [
                         'method'  => 'POST',
                         'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                         'content' => http_build_query($data),
                     ],
                 ];
                 $context = stream_context_create($options);
                 $verify = file_get_contents($url, false, $context);
                 if ($verify === false) {
                     Session::flash("error_kontakt", "Es gab ein Problem bei der reCAPTCHA-Verifizierung.");
                     return redirect()->to(route('Kontakt') . '#formKontakt');
                 }

                  // Überprüfe das Antwort-JSON von Google
                 $captcha_success = json_decode($verify);

                 if ($captcha_success->success) {
                     // Erfolgreiche Verifizierung
                 } else {
                     $errorCodes = implode(", ", $captcha_success->{"error-codes"});
                     Session::flash("error_kontakt", "reCAPTCHA ungültig. Fehler: " . $errorCodes);
                     return redirect()->to(route('Kontakt') . '#formKontakt');
                 }


                 try {

                     Mail::send('emails.email', [
                         'name' => $name,
                         'email' => $email,
                         'text' => $text
                     ], function ($message) use ($email) {
                         $message->to('herr.dennisblacky@hotmail.de')
                             ->subject('Neue Kontaktformular-Anfrage')
                             ->from($email)
                             ->replyTo($email);
                     });


                     Session::flash("msg_kontakt", "Ihre Nachricht wurde erfolgreich gesendet.");
                 } catch (\Exception $e) {
                     Session::flash("error_kontakt", "Da ist etwas schief gelaufen. Fehlercode 0x5");
                     return redirect()->to(route('Kontakt') . '#formKontakt');
                 }
             } else {
                 Session::flash("error_kontakt", "Bitte alle Felder ausfüllen.");
             }
             return redirect()->to(route('Kontakt') . '#formKontakt');

    }


    public function abmelden()
    {
        if (!Session::has('admin')) {
            return redirect("Admin");
        } else {
            Session::forget('admin');
            return redirect('/')->with('success', 'Erfolgreich abgemeldet.');
        }
    }


}

