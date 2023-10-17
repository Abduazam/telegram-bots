<?php

namespace App\Services\Bots\Models\BotUserLogs;

use App\Models\Bots\Users\BotUser;
use App\Models\Bots\Users\BotUserLog;

class BotUserLogCreateService
{
    public function __construct(
        protected BotUser $user,
        protected int $id,
    ) { }

    public function createByCategoryId(): void
    {
        $log = BotUserLog::where('bot_user_id', $this->user->id)->first();
        if ($log) {
            (new BotUserLogUpdateService($log))->updateCategoryId($this->id);
        } else {
            BotUserLog::create([
                'bot_user_id' => $this->user->id,
                'bot_category_id' => $this->id,
            ]);
        }
    }

    public function createByTaskId(): void
    {
        $log = BotUserLog::where('bot_user_id', $this->user->id)->first();
        if ($log) {
            (new BotUserLogUpdateService($log))->updateTaskId($this->id);
        } else {
            BotUserLog::create([
                'bot_user_id' => $this->user->id,
                'bot_user_task_id' => $this->id,
            ]);
        }
    }
}
