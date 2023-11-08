<?php

namespace App\Repository\Bots\Models\General;

use App\Models\Bots\General\Users\BotUser;

class BotUserRepository
{
    public function findByBotAndChatIds(int $bot_id, int $chat_id)
    {
        return BotUser::where('bot_id', $bot_id)->where('chat_id', $chat_id)->first();
    }
}
