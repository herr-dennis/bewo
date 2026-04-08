<?php
namespace App\Http\Controllers;

use App\Models\SendingEmails;
use App\Models\Termine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class NewsletterController extends Controller
{

    public function store(Request $request) {

        if ($request->has("veranstaltung") && $request->has("datum")) {
            $veranstaltung = $request->input("veranstaltung");
            $datum = $request->input("datum");
            $wiederkehrend  = (bool)$request->input("sendEmailRepeat");

            if ($request->has("text")) {
                $text = nl2br($request->input('text'), false);
            } else {
                $text = null;
            }

            $bild = null;
            if ($request->has("bild") != null) {

                $path = Storage::putFile('/public/images', $request->file('bild'));
                $path = "/storage/images/" . basename($path);
                $bild = $path;
            }

            $messages = [];

            try {
                Termine::query()->insert([
                    'veranstaltung' => $veranstaltung,
                    'datum' => $datum,
                    'text' => $text,
                    'bildUrl' => $bild,
                    "wiederkehrend" => $wiederkehrend
                ]);

                if ($request->input("sendEmail") == "akzeptiert"){
                    $send = new SendingEmails();

                    if ($send->send($datum, $text)) {
                        $messages[] = [
                            'type' => 'success',
                            'text' => 'Der Newsletter-Versand wurde gestartet und wird im Hintergrund verarbeitet..'
                        ];
                    } else {
                        $messages[] = [
                            'type' => 'error',
                            'text' => 'Fehler beim Senden der E-Mails. Bitte überprüfen Sie die Logs.'
                        ];
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Veranstaltung wurde erfolgreich angelegt.',
                    'messages' => $messages
                ], 201);

            } catch (\Exception $exception) {

                return response()->json([
                    'success' => false,
                    'message' => 'Datenbankfehler.',
                    'messages' => $messages
                ], 500);
            }

        } else {

            return response()->json([
                'success' => false,
                'message' => 'Fehler beim Übermitteln.',
                'messages' => []
            ], 400);
        }
    }
}
