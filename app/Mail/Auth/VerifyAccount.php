<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyAccount extends Mailable
{
    use Queueable, SerializesModels;

    protected $full_name;
    protected $email;
    protected $password;

    public function __construct($full_name, $email, $password)
    {
        $this->full_name = $full_name;
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->from('mail@example.com', config('app.name'))
            ->subject('Claim your account')
            ->markdown('mails.auth.verify-account')
            ->with([
                'full_name' => $this->full_name,
                'email' => $this->email,
                'password' => $this->password
            ]);
    }
}
