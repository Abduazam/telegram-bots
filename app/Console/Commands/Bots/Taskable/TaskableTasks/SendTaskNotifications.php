<?php

namespace App\Console\Commands\Bots\Taskable\TaskableTasks;

use App\Helpers\Bots\General\Messages\Message;
use App\Models\Bots\Taskable\Tasks\BotUserTask;
use App\Models\Bots\Telegram\Telegram;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendTaskNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:send-task-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bot: sending users notification of task';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $now = Carbon::now()->format('H:i');

        $tasks = BotUserTask::with('user')
            ->where('schedule_time', $now)
            ->where('active', true)
            ->get();

        if ($tasks->isNotEmpty()) {
            $telegram = new Telegram(config('telegram.tokens.virdlarim'));

            $tasks->each(function ($task) use ($telegram) {
                $text = Message::getTaskNotificationInfo($task);

                $telegram->sendMessage([
                    'chat_id' => $task->user->chat_id,
                    'text' => $text,
                    'parse_mode' => 'html',
                ]);
            });
        }
    }
}
