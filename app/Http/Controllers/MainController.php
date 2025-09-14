<?php

namespace App\Http\Controllers;
use App\Mail\Kontaktformular;
use App\Models\Admins;
use App\Models\Dates;
use App\Models\InkrementAufrufe;
use App\Models\Mitarbeiter;
use App\Models\MyLogger;
use App\Models\Newsletter;
use App\Models\Termine;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use App\Models\SendingEmails;

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
        try {
            $mitarbeiter = mitarbeiter::query()->select('*')->get();
        } catch (\Exception $e) {
            Session::flash("error_db", $e->getMessage());
        }
        return view('teamView', ['data' => $mitarbeiter]);
    }

    public function getTermine()
    {
        try {
            // Termine aus der Datenbank holen und direkt sortieren
            $termine = Termine::query()->orderBy('datum')->get();

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
        if (Session::has('admin')) {
            if (Session::get("admin") === true) {
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

        if (Session::has('admin')) {
            if (Session::get("admin") === true) {
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

        if (!Session::has('admin')) {
            return redirect("Admin");
        }
        $aufrufe = null;
        try {
            $aufrufe = Dates::query()->select("aufrufe")->get();
        } catch (\Exception $e) {
            Session::flash("error_db", $e->getMessage());
        }

        return view("verwaltungView", ['data' => $aufrufe]);
    }


    public function getÜbersicht()
    {
        if (!Session::has('admin')) {
            return redirect("Admin");
        }

        try {
            $termine = Termine::query()->select('*')->get();
            $data = Mitarbeiter::query()->select('*')->get();
            $email = Newsletter::query()->select('*')->get();
        } catch (\Exception $e) {
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

        if (!Session::has('admin')) {
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

                if ($request->file()) {
                    $path = Storage::putFile('/public/images', $request->file('bild'));
                    $path = "/storage/images/" . basename($path);
                    $bild = $path;

                    // Überprüfen, ob die Datei existiert
                    if (!Storage::exists($path)) {
                        Session::flash("error", "Bild defekt oder zu groß");
                    }
                }

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
                $wiederkehrend  = $request->get("sendEmailRepeat") ? true : false;

                if ($request->has("text")) {
                    $text = nl2br($request->input('text'), false);
                } else {
                    $text = null;
                }
                $bild = null;
                if ($request->file() != null) {
                    $path = Storage::putFile('/public/images', $request->file('bild'));
                    $path = "/storage/images/" . basename($path);
                    $bild = $path;

                }

                try {
                    Termine::query()->insert([
                        'veranstaltung' => $veranstaltung,
                        'datum' => $datum,
                        'text' => $text,
                        'bildUrl' => $bild,
                        "wiederkehrend" => $wiederkehrend
                    ]);
                    Session::flash("msg_2", "Aktuelles eingepflegt!.");
                } catch (\Exception $exception) {
                    Session::flash("error_2", $exception->getMessage());
                }
                if($request->input("sendEmail")=="akzeptiert"){

                    $send = new SendingEmails();

                    if ($send->send($datum, $text)) {
                        Session::flash("msg_email", "Die E-Mails wurden erfolgreich gesendet.");
                    } else {
                        Session::flash("error_email", "Fehler beim Senden der E-Mails. Bitte überprüfen Sie die Logs.");
                    }

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

        if (!Session::has('admin') === true) {
            return redirect("Admin");
        }

        if ($request->input("form1") == 1) {
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

        if ($request->input("form2") == 2) {
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

        if ($request->input("form3") == 3) {
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
        return redirect()->back();
    }

    /**
     * @param Request $request Formular Parameter
     *  Fügt die Daten des Newsletters in die Datenbank ein.
     */
    public function insertNewsletter(Request $request)
    {
        $Logger = new MyLogger();
        $secretKey = "6LeK2PQqAAAAAOOKhuk07_UKdSkS2gJdDCZrF3_M";
        # reCAPTCHA v3 Validierung
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $data = [
            'secret' =>   $secretKey,
            'response' => $_POST['g-recaptcha-response'] ?? '',
            'remoteip' => $_SERVER['REMOTE_ADDR'] ?? null
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        try {
            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            if ($response === false) {
                throw new \Exception("Fehler bei der Verbindung zu reCAPTCHA.");
            }
            $res = json_decode($response, true);
        } catch (\Exception $e) {
            return back()->with('error', 'Fehler bei der Verbindung zu reCAPTCHA.');
        }

        $Logger->log($response);

        if (!is_array($res) || !isset($res['success']) || !$res['success'] || $res['score'] < 0.5) {
            return back()->with('error', 'reCAPTCHA-Überprüfung fehlgeschlagen. Bitte versuchen Sie es erneut.');
        }

        # Validierung der Eingaben
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
        ]);

        try {
            $name = $request->input('name');
            $email = $request->input('email');

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return back()->with('error', 'Ungültige E-Mail-Adresse!');
            }

            Newsletter::query()->insert([
                'email' => $email,
                'name' => $name,
                'consent_given_at' => now(),
            ]);

            Session::flash("msg", "Newsletter erfolgreich angelegt.");
        } catch (\Exception $e) {
            $Logger->log("DB-Fehler: " . $e->getMessage());
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
            $Logger = new MyLogger();
            # BEGIN Setting reCaptcha v3 validation data

            if(empty($_POST['g-recaptcha-response'])){
                return back()->with('error_kontakt', 'reCAPTCHA Übertragung fehlgeschlagen.');
            }
            $secretKey = "6LeK2PQqAAAAAOOKhuk07_UKdSkS2gJdDCZrF3_M";
            $url = "https://www.google.com/recaptcha/api/siteverify";
            $data = [
                'secret' => $secretKey,
                'response' => $_POST['g-recaptcha-response'],
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ];


            $Logger->log( "Geheim".$secretKey."\n"."ServerID: ".$_SERVER['REMOTE_ADDR']);


            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );

            # Creates and returns stream context with options supplied in options preset
            $context = stream_context_create($options);
            # file_get_contents() is the preferred way to read the contents of a file into a string
            try {
                $response = @file_get_contents($url, false, $context);
                if ($response === false) {
                    throw new \Exception("Verbindung zu reCAPTCHA fehlgeschlagen. Bitte versuchen Sie es erneut.");
                }
            } catch (\Exception $e) {
                $Logger->log("Verbindung".$e->getMessage());
            }

            # Takes a JSON encoded string and converts it into a PHP variable
            $res = json_decode($response, true);
            # END setting reCaptcha v3 validation data

            if (!is_array($res)) {
                $Logger->log("Fehler: API-Antwort ist ungültig. Antwort: " . $response);
            }else{
                if (!$res["success"]) {
                    $Logger->log("Fehler: " . json_encode($res["error-codes"]));
                }
            }


            if ($res['success'] && $res['score'] >= 0.5) {

                $Logger->log($res);

                try {


                    Mail::to("info@bewo-paiva.de")
                        ->send(new Kontaktformular($name, $email, $text));

                    Session::flash("msg_kontakt", "Ihre Nachricht wurde erfolgreich gesendet.");
                } catch (\Exception $e) {
                    $Logger->log($e->getMessage());
                    Session::flash("error_kontakt", "Da ist etwas schief gelaufen. Fehlercode 0x5");
                    return redirect()->to(route('Kontakt') . '#formKontakt');
                }
            } else {
                Session::flash("error_kontakt", "Fehler beim Prüfen des Recaptcha. Nutzen Sie: info@bewo-paiva.de");
                return redirect()->to(route('Kontakt') . '#formKontakt');
            }
        } else {
            Session::flash("error_kontakt", "Bitte alle Felder ausfüllen.");
            return redirect()->to(route('Kontakt') . '#formKontakt');
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

    public function getLogs()
    {
        if (!Session::has('admin')) {
            return redirect("Admin");
        }

        $filePath = "log.txt";

        if (!file_exists($filePath)) {
            return view("logsView", ['logs' => "Log-Datei nicht gefunden."]);
        }

        $logs = array();
        $file = fopen($filePath, "r");
        while (!feof($file)) {
            $logs[] = fgets($file);
        }
        fclose($file);

        return view("logsView",  ["data"=>$logs]);
    }


    public function logLöschen()
    {
        if (!Session::has('admin')) {
            return redirect("Admin");
        }

        $filePath = "log.txt";

        if (!file_exists($filePath)) {
            return view("logsView", ['logs' => "Log-Datei nicht gefunden."]);
        }

        // Datei mit "w" öffnen, um sie zu leeren
        $file = fopen($filePath, "w");

        if ($file) {
            fclose($file);
        } else {
            Session::flash("error", "Fehler beim Laden der Datei");
            return view("logsView");
        }
        return redirect()->back()->with('msg', 'Log-Datei wurde erfolgreich geleert.');
    }




}


