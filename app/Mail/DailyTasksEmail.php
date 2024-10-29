<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class DailyTasksEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    /**
     * Summary of __construct
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Summary of build
     * @return DailyTasksEmail
     */
    public function build()
    {
        return $this->subject('Your Pending Tasks for Today')
                    ->view('emails.daily_tasks')
                    ->with('tasks', $this->user->tasks);
    }
}
