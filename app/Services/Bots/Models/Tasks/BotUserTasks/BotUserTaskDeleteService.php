<?php

namespace App\Services\Bots\Models\Tasks\BotUserTasks;

use App\Models\Bots\Tasks\BotUserTask;
use App\Models\Bots\Tasks\BotUserTaskLog;
use App\Models\Bots\Users\BotUser;

class BotUserTaskDeleteService
{
    protected BotUserTask $task;

    public function __construct(BotUser $user, ?int $task_id = null) {
        if (is_null($task_id)) {
            $log = BotUserTaskLog::where('bot_user_id', $user->id)->first();
            $this->task = BotUserTask::where('id', $log->bot_user_task_id)->first();
        } else {
            $this->task = BotUserTask::where('id', $task_id)->first();
        }
    }

    public function delete(): void
    {
        $this->task->delete();
    }

    public function forceDelete(): void
    {
        $this->task->forceDelete();
    }
}
