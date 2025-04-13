<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendingEmails
{


    function send($date, $text)
    {
        {
            $newsletter = Newsletter::all();
            try {
                foreach ($newsletter as $item) {
                    Mail::send('emails.newsletterEmail', [
                        'name' => $item["name"],
                        'datum' => $date,
                        'text' => $text,
                        'consent_given_at' => $item["consent_given_at"],
                    ], function ($message) use ($item) {
                        $message->to($item["email"])
                            ->subject('Neuer Newsletter')
                            ->from("info@bewo-paiva.de", "BeWo Paiva")
                            ->replyTo($item["email"]);
                    });
                }
                return true; // Erfolg
            } catch (\Exception $e) {
                Log::error("Fehler beim Senden einer E-Mail\n\n" . $e->getMessage());
                $logger = new MyLogger();
                $logger->log("Fehler beim Senden einer E-Mail\n\n" . $e->getMessage());
                return false; // Fehler
            }
        }
    }

}
