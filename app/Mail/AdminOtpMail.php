<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $code,
        public string $siteName,
        public int $ttlMinutes
    ) {}

    public function build()
    {
        return $this
            ->subject("Kode Verifikasi Admin - {$this->siteName}")
            ->view('emails.kode-otp');
    }
}
