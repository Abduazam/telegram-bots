<?php

namespace App\Services\Bots\Models\BotUsers;

use App\Models\Bots\Telegram\Telegram;
use App\Models\Bots\Users\BotUser;

class BotUserFindService
{
    public function __construct(protected ?int $chat_id = null) { }

    public function __invoke()
    {
        $user = BotUser::where('chat_id', $this->chat_id)->first();
        return $user ? $user : false;
    }
}
