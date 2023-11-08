<?php

namespace App\Services\Bots\General\BotUser;

use App\Models\Bots\General\Users\BotUser;

class BotUserExistsCheckService
{
    public function __construct(
        protected int $bot_id,
        protected int $chat_id,
    ) { }

    public function __invoke(): bool
    {
        return BotUser::where('bot_id', $this->bot_id)
            ->where('chat_id', $this->chat_id)
            ->exists();
    }
}
