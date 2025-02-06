<?php

namespace App\Http\Controllers;

use App\Models\Admins;
use App\Models\Mitarbeiter;
use App\Models\Termine;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use mysql_xdevapi\Exception;

class MainController extends BaseController
{
    public function getHome()
    {
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

        $mitarbeiter = mitarbeiter::query()->select('*')->get();

        return view('teamView', ['data' => $mitarbeiter]);
    }

    public function getTermine()
    {

        $termine = Termine::query()->select('*')->get()->sortByDesc('datum');


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
                if ($password_input === $admin->pw) {
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
        return view("verwaltungView");
    }


    public function getÜbersicht()
    {

        $data = Mitarbeiter::query()->select('*')->get();
        return view("useroverview", ['data' => $data]);

    }


    public function insertVerwaltung(Request $request)
    {
        if ($request->input("form_name") === "form1") {
            $anchor = $request->input("anchor");
            if ($request->has("name") && $request->has("position")) {

                $name = $request->get("name");
                $position = $request->get("position"); // Tippfehler bei postion korrigiert
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

                } catch (Exception $exception) {
                    Session::flash("error", "Fehler beim Einfügen: " . $exception->getMessage());
                }

            } else {
                Session::flash("error", "Fehlercode 0x1: Name und Position erforderlich.");
            }
            Session::flash("error", "Fehlercode 0x1: Name und Position erforderlich.");
            return redirect()->to(route('Verwaltung') . '#form1');
        }


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

                if ($request->hasFile('bild')) {
                    echo "Datei hochgeladen!";
                } else {
                    echo "Keine Datei hochgeladen.";
                }


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
                } catch (Exception $exception) {
                    Session::flash("error_2", $exception->getMessage());
                }
            }
        } else {
            Session::flash("error_2", "Fehlercode 0x2: Fehler beim Einfügen .");
        }
      //  return redirect()->to(route('Verwaltung') . '#form2');
    }

    public function deleteUser(Request $request)
    {
        $id = $request->input('id');

        if ($request->input("formDelete") === "delete") {
            try {
                $deletedRows = Mitarbeiter::query()->where('id', $id)->delete();

                if ($deletedRows) {
                    Session::flash("msg", "Mitarbeiter erfolgreich gelöscht.");
                } else {
                    Session::flash("error", "Kein Mitarbeiter mit der angegebenen ID gefunden.");
                }
            } catch (Exception $exception) {
                Session::flash("error", "Fehler beim Löschen: " . $exception->getMessage());
            }
        } else {
            Session::flash("error", "Ungültiger Löschvorgang.");
        }

        return redirect()->back();
    }




}

