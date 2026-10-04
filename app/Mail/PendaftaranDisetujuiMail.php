<?php

namespace App\Mail;

use App\Models\Anggota;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PendaftaranDisetujuiMail extends Mailable
{
    use Queueable, SerializesModels;

    public Anggota $anggota;
    public string $email;
    public string $password;

    /**
     * Create a new message instance.
     */
    public function __construct(Anggota $anggota, string $email, string $password)
    {
        $this->anggota = $anggota;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat! Pendaftaran Anggota Karang Taruna Karya Bhakti Diterima',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pendaftaran-disetujui',
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
