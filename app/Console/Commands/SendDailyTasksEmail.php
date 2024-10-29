<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\DailyTasksEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendDailyTasksEmailJob;
use Illuminate\Support\Facades\Mail;

class SendDailyTasksEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-tasks-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::whereHas('tasks', function($query) {
            $query->where('status', 'Pending');
        })->with(['tasks' => function($query) {
            $query->where('status', 'Pending');
        }])->get();

        foreach ($users as $user) {

            try {
                Mail::to($user->email)->send(new DailyTasksEmail($user));
                Log::info("Email sent to: " . $user->email . "\n");
            } catch (\Exception $e) {
                Log::error('Failed to send email to ' . $user->email . ': ' . $e->getMessage());
            }
        }
    }
}
