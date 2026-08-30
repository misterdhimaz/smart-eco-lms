<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOtpEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $nama;
    public $otp;
    public $subject;

    public function __construct($email, $nama, $otp, $subject)
    {
        $this->email = $email;
        $this->nama = $nama;
        $this->otp = $otp;
        $this->subject = $subject;
    }

    public function handle(): void
    {
        Mail::raw("Halo {$this->nama},\n\nKode OTP Anda adalah: {$this->otp}\n\nPERHATIAN: Kode ini hanya berlaku selama 2 MENIT. Jangan bagikan kepada siapa pun.", function ($message) {
            $message->to($this->email)->subject($this->subject);
        });
    }
}
