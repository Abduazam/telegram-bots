<?php

namespace App\Services\Bots\Models\BotUserLogs;

use App\Models\Bots\Users\BotUser;
use App\Models\Bots\Users\BotUserLog;

class BotUserLogCreateService
{
    public function __construct(
        protected BotUser $user,
        protected int $category_id,
    ) { }

    public function __invoke(): void
    {
        $log = BotUserLog::where('bot_user_id', $this->user->id)->first();
        if ($log) {
            (new BotUserLogUpdateService($log))->updateCategoryId($this->category_id);
        } else {
            BotUserLog::create([
                'bot_user_id' => $this->user->id,
                'bot_category_id' => $this->category_id,
            ]);
        }
    }
}
