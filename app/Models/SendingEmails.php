<?php
namespace App\Models;

use App\Mail\NewsletterBenachrichtigung;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendingEmails
{
    public function send($date, $text)
    {
        $newsletter = Newsletter::all();
        if ($date === null) {
            $date = now();
        }

        $fehlerhafteEmpfaenger = [];

        foreach ($newsletter as $item) {
            try {
                if (!filter_var($item["email"], FILTER_VALIDATE_EMAIL)) {
                    throw new \Exception("Ungültige E-Mail-Adresse: {$item['email']}");
                }

                Mail::to($item["email"])->send(
                    new NewsletterBenachrichtigung(
                        $item["name"],
                        $item["email"],
                        $text,
                        $date,
                        $item["consent_given_at"] ?: now()
                    )
                );
            } catch (\Exception $e) {
                Log::warning("Fehler beim Senden an {$item['email']}: " . $e->getMessage());
                $logger = new MyLogger();
                $logger->log("Fehler beim Senden an {$item['email']}: " . $e->getMessage());
                $fehlerhafteEmpfaenger[] = $item['email'];
            }
        }

        if (count($fehlerhafteEmpfaenger) > 0) {
            Log::info("Folgende Empfänger konnten nicht erreicht werden: " . implode(', ', $fehlerhafteEmpfaenger));
            return false;
        }

        return true;
    }
}

