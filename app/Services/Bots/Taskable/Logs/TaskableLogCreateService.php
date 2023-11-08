<?php

namespace App\Services\Bots\Taskable\Logs;

use App\Models\Bots\General\Users\BotUser;
use App\Models\Bots\Taskable\Logs\TaskableLog;

class TaskableLogCreateService
{
    public function __construct(
        protected BotUser $user,
        protected int $id,
    ) { }

    public function createByCategoryId(): void
    {
        $log = TaskableLog::where('bot_user_id', $this->user->id)->first();
        if ($log) {
            (new TaskableLogUpdateService($log))->updateCategoryId($this->id);
        } else {
            TaskableLog::create([
                'bot_user_id' => $this->user->id,
                'taskable_category_id' => $this->id,
            ]);
        }
    }

    public function createByTaskId(): void
    {
        $log = TaskableLog::where('bot_user_id', $this->user->id)->first();
        if ($log) {
            (new TaskableLogUpdateService($log))->updateTaskId($this->id);
        } else {
            TaskableLog::create([
                'bot_user_id' => $this->user->id,
                'taskable_task_id' => $this->id,
            ]);
        }
    }
}
