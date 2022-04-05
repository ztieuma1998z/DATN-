<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $title;
    protected $content;

    public function __construct($name, $title, $content)
    {
        $this->name = $name;
        $this->title = $title;
        $this->content = $content;
    }

    public function build()
    {
        return $this->from('mail@example.com', config('app.name'))
            ->subject($this->title)
            ->markdown('mails.notify-mail')
            ->with([
                'name' => $this->name,
                'content' => $this->content
            ]);
    }
}
