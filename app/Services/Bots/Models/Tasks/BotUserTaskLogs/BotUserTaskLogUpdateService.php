<?php

namespace App\Services\Bots\Models\Tasks\BotUserTaskLogs;

use App\Models\Bots\Tasks\BotUserTask;
use App\Models\Bots\Tasks\BotUserTaskLog;
use App\Contracts\Enums\Bots\General\BotCategoriesTypeEnum;

class BotUserTaskLogUpdateService
{
    public function __construct(
        protected BotUserTaskLog $log,
        protected ?BotCategoriesTypeEnum $class = null,
    ) { }

    public function categoryUpdate($category): void
    {
        if ($this->class === BotCategoriesTypeEnum::BOT_USER_CATEGORY) {
            $this->log->update([
                'bot_user_category_id' => $category->id,
            ]);
        } else {
            $this->log->update([
                'bot_category_id' => $category->id,
            ]);
        }
    }

    public function taskUpdate(BotUserTask $task): void
    {
        $this->log->update([
            'bot_user_task_id' => $task->id,
        ]);
    }
}
