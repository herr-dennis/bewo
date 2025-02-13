<?php

namespace App\Models;

use Illuminate\Support\Facades\Mail;

class SendingEmails
{


    function send($date, $text)
    {
        {
            $newsletter = Newsletter::all(); // Kürzer als `query()->select("*")->get()`

            try {
                foreach ($newsletter as $item) {
                    Mail::send('emails.newsletterEmail', [
                        'name' => $item["name"],
                        'datum' => $item["datum"],
                        'text' => $text,
                        'consent_given_at' => $item["consent_given_at"],
                    ], function ($message) use ($item) {
                        $message->to($item["email"])
                            ->subject('Neuer Newsletter')
                            ->from("info-bewo-paiva@gmail.com")
                            ->replyTo("info-bewo-paiva@gmail.com");
                    });
                }
                return true; // Erfolg
            } catch (\Exception $e) {
                \Log::error("Fehler beim Versand der E-Mails: {$e->getMessage()}");
                return false; // Fehler
            }
        }
    }

}
