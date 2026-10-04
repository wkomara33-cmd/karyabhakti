<?php

namespace App\Mail;

use App\Models\Anggota;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PendaftaranDitolakMail extends Mailable
{
    use Queueable, SerializesModels;

    public Anggota $anggota;
    public ?string $alasan;

    /**
     * Create a new message instance.
     */
    public function __construct(Anggota $anggota, ?string $alasan = null)
    {
        $this->anggota = $anggota;
        $this->alasan = $alasan;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan Hasil Seleksi Karang Taruna Karya Bhakti',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pendaftaran-ditolak',
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
