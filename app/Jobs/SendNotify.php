<?php

namespace App\Jobs;

use App\Mail\NotifyMail;
use App\Models\Student;
use App\Models\Teacher;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $title;
    protected $content;

    public function __construct($title, $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    public function handle()
    {
        foreach (Teacher::all() as $user) {
            SendNotifySmall::dispatch($user->email, $user->name, $this->title, $this->content);
        }
        foreach (Student::all() as $user) {
            SendNotifySmall::dispatch($user->email, $user->name, $this->title, $this->content);
        }
    }
}
