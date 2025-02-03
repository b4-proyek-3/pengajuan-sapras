<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $token;

    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Kode Verifikasi untuk Reset Password')
                    ->view('pages.Auth.reset_password')
                    ->with([
                        'email' => $this->email,
                        'token' => $this->token,
                    ]);
    }
}
