<?php

namespace App\Services\Bots\Models\BotUserLogs;

use App\Models\Bots\Users\BotUserLog;

class BotUserLogUpdateService
{
    public function __construct(protected BotUserLog $log) { }

    public function updateCategoryId(int $category_id): void
    {
        $this->log->update([
            'bot_category_id' => $category_id,
        ]);
    }

    public function updateTaskId(int $task_id): void
    {
        $this->log->update([
            'bot_user_task_id' => $task_id,
        ]);
    }
}
