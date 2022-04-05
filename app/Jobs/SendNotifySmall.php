<?php

namespace App\Jobs;

use App\Mail\NotifyMail;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNotifySmall implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $name;
    protected $title;
    protected $content;

    public function __construct($email, $name, $title, $content)
    {
        $this->email = $email;
        $this->name = $name;
        $this->title = $title;
        $this->content = $content;
    }

    public function handle()
    {
        Mail::to($this->email)
            ->send(new NotifyMail(
                    $this->name,
                    $this->title,
                    $this->content
                )
            );
    }
}
