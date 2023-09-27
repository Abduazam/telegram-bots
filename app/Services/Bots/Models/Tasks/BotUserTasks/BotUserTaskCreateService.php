<?php

namespace App\Services\Bots\Models\Tasks\BotUserTasks;

use App\Models\Bots\Users\BotUser;
use App\Models\Bots\Tasks\BotUserTask;
use App\Models\Bots\Tasks\BotUserTaskLog;
use App\Services\Bots\Models\Tasks\BotUserTaskLogs\BotUserTaskLogUpdateService;

class BotUserTaskCreateService
{
    public function __construct(
        protected BotUser $user,
        protected ?string $text = null,
    ) { }

    public function createTextTask(): void
    {
        $log = BotUserTaskLog::where('bot_user_id', $this->user->id)->first();

        if (isset($this->text)) {
            $create_array = [
                'bot_user_id' => $this->user->id,
                'description' => base64_encode($this->text),
            ];

            if ($log->isBotCategory()) {
                $create_array['bot_category_id'] = $log->bot_category_id;
            } else {
                $create_array['bot_user_category_id'] = $log->bot_user_category_id;
            }

            $task = BotUserTask::create($create_array);

            (new BotUserTaskLogUpdateService($log))->taskUpdate($task);
        }
    }
}
