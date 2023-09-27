<?php

namespace App\Services\Bots\Models\Tasks\BotUserTasks;

use App\Models\Bots\Users\BotUser;
use App\Models\Bots\Tasks\BotUserTask;
use App\Models\Bots\Tasks\BotUserTaskLog;

class BotUserTaskUpdateService
{
    protected BotUserTaskLog $log;

    public function __construct(
        protected BotUser $user,
        protected int|string|null $text = null,
    ) {
        $this->log = BotUserTaskLog::where('bot_user_id', $this->user->id)->first();
    }

    public function updateAmountTask(): void
    {
        if (isset($this->text)) {
            BotUserTask::where('id', $this->log->bot_user_task_id)->where('bot_user_id', $this->user->id)->update([
                'amount' => $this->text,
            ]);
        }
    }

    public function updateScheduleTask(): void
    {
        if (isset($this->text)) {
            BotUserTask::where('id', $this->log->bot_user_task_id)->where('bot_user_id', $this->user->id)->update([
                'schedule_time' => $this->text,
            ]);
        }
    }

    public function updateActiveTask(bool $active): void
    {
        BotUserTask::where('id', $this->log->bot_user_task_id)->where('bot_user_id', $this->user->id)->update([
            'active' => $active,
        ]);
    }
}
