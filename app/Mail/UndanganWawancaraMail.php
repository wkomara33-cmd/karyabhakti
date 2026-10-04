<?php

namespace App\Mail;

use App\Models\Anggota;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UndanganWawancaraMail extends Mailable
{
    use Queueable, SerializesModels;

    public Anggota $anggota;

    /**
     * Create a new message instance.
     */
    public function __construct(Anggota $anggota)
    {
        $this->anggota = $anggota;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Undangan Wawancara Calon Anggota Karang Taruna Karya Bhakti',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.undangan-wawancara',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
