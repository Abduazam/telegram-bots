<?php

namespace App\Services\Bots\Taskable\Logs;

use App\Models\Bots\General\Users\BotUser;
use App\Models\Bots\Taskable\Logs\TaskableLog;

class TaskableLogCreateService
{
    public function __construct(
        protected BotUser $user,
        protected int|string $value,
    ) { }

    public function createByCategoryId(): void
    {
        if ($this->user->taskable_log) {
            (new TaskableLogUpdateService($this->user->taskable_log))->updateCategoryId($this->value);
        } else {
            TaskableLog::create([
                'bot_user_id' => $this->user->id,
                'taskable_category_id' => $this->value,
            ]);
        }
    }

    public function createByTaskId(): void
    {
        if ($this->user->taskable_log) {
            (new TaskableLogUpdateService($this->user->taskable_log))->updateTaskId($this->value);
        } else {
            TaskableLog::create([
                'bot_user_id' => $this->user->id,
                'taskable_task_id' => $this->value,
            ]);
        }
    }

    public function createBySectionName(): void
    {
        if ($this->user->taskable_log) {
            (new TaskableLogUpdateService($this->user->taskable_log))->updateSectionName($this->value);
        } else {
            TaskableLog::create([
                'bot_user_id' => $this->user->id,
                'section_name' => $this->value,
            ]);
        }
    }
}
