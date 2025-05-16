<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterBenachrichtigung extends Mailable
{
    use Queueable, SerializesModels;
    public string $name;
    public string $email;
    public string $text;
    public string $datum;
    public string $consent_given_at;

    public function __construct(string $name, string $email, string $text, string $datum, string $consent_given_at)
    {
        $this->name = $name;
        $this->email = $email;
        $this->text = $text;
        $this->datum = $datum;
        $this->consent_given_at = $consent_given_at;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Newsletter Benachrichtigung',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletterEmail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
