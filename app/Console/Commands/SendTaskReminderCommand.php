<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\SendReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendTaskReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task_reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send task reminder emails to users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tasks = Task::query()->with('user')->whereNotNull('user_id')
            ->where('reminder_at', '<=', now()->toDateTimeString())
            ->get();
        if ($tasks->count() > 0) {
            foreach ($tasks as $task) {
                $task->user->notify(new SendReminderNotification($task));
                $task->update(['reminder_at' => null]);
            }
            $this->info($tasks->count() . ' Reminder Sent Successfully!');
        } else {
            $this->warn('Sorry, No reminder to sent!!');
        }

        return 0;
    }
}
