<?php

namespace App\Services\Bots\Models\Tasks\BotUserTaskLogs;

use App\Models\Bots\Users\BotUser;
use App\Models\Bots\Tasks\BotUserTaskLog;
use App\Contracts\Enums\Bots\General\BotCategoriesTypeEnum;

class BotUserTaskLogCreateService
{
    public function __construct(
        protected $category,
        protected BotCategoriesTypeEnum $class,
        protected BotUser $user,
    ) { }

    public function __invoke(): void
    {
        $log = BotUserTaskLog::where('bot_user_id', $this->user->id)->first();
        if ($log) {
            (new BotUserTaskLogUpdateService($log, $this->class))->categoryUpdate($this->category);
        } else {
            if ($this->class === BotCategoriesTypeEnum::BOT_USER_CATEGORY) {
                BotUserTaskLog::create([
                    'bot_user_id' => $this->user->id,
                    'bot_user_category_id' => $this->category->id,
                ]);
            } else {
                BotUserTaskLog::create([
                    'bot_user_id' => $this->user->id,
                    'bot_category_id' => $this->category->id,
                ]);
            }
        }
    }
}
