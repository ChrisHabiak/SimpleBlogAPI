<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserResetPasswordLinkMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $token,$email;

    public function __construct($email, $token)
    {
        $this->token = $token;
        $this->email = $email;

    }

    public function build()
    {
        return $this
            ->subject('Password Reset Request')
            ->view('emails.reset-password-link')
            ->with([
                'url_token' => url("#/reset-password/{$this->token}?email={$this->email}")
            ]);
    }
}
