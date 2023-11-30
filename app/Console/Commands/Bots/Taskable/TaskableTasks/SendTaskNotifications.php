<?php

namespace App\Console\Commands\Bots\Taskable\TaskableTasks;

use App\Helpers\Bots\Taskable\Buttons\Inline\Actions\TaskDoneButton;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Models\Bots\Telegram\Telegram;
use App\Helpers\Bots\General\Messages\Message;
use App\Models\Bots\Taskable\Tasks\TaskableTask;

class SendTaskNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taskable:send-task-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Taskable: sending users notification of task';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $now = Carbon::now()->format('H:i');

        $tasks = TaskableTask::with('user')
            ->where('schedule_time', $now)
            ->where('active', true)
            ->get();

        if ($tasks->isNotEmpty()) {
            $telegram = new Telegram(config('telegram.bots.taskable.token'));

            $tasks->each(function ($task) use ($telegram) {
                $text = Message::getTaskNotificationInfo($task);

                $telegram->sendMessage([
                    'chat_id' => $task->user->chat_id,
                    'text' => $text,
                    'parse_mode' => 'html',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                (new TaskDoneButton($task->id))()
                            ],
                        ],
                    ])
                ]);
            });
        }
    }
}
