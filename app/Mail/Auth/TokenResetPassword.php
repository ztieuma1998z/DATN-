<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TokenResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;
    protected $email;
    protected $role;

    public function __construct($token, $email, $role)
    {
        $this->token = $token;
        $this->email = $email;
        $this->role = $role;
    }

    public function build()
    {
        return $this->from('mail@example.com', config('app.name'))
            ->subject('Change Password')
            ->markdown('mails.auth.send-token')
            ->with([
                'token' => $this->token,
                'email' => $this->email,
                'role' => $this->role,
            ]);
    }
}
