<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class EmailVerification extends Mailable
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
    public function build()
    {
        return $this->subject('Verify Your Email Address')
            ->view('auth.verifyEmail')
            ->with([
                'verificationToken' => $this->user->verification_token,
            ]);
    }
}

