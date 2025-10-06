<?php

namespace App\Mail;

use App\Models\Rapat; // Import model Rapat
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RapatUndanganMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rapat; // Properti publik untuk menampung data rapat

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Rapat $rapat
     * @return void
     */
    public function __construct(Rapat $rapat)
    {
        $this->rapat = $rapat; // Terima data rapat melalui constructor
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Undangan Rapat: ' . $this->rapat->agenda, // Subjek email dinamis
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.undangan_rapat', // Tentukan view Blade untuk email
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