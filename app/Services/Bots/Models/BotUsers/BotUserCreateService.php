<?php

namespace App\Services\Bots\Models\BotUsers;

use App\Events\Bots\General\BotUsers\BotUserCreated;
use App\Models\Bots\General\Users\BotUser;

class BotUserCreateService
{
    public function __construct(
        protected int $chat_id,
        protected string $first_name,
        protected ?string $username,
        protected int $bot_id,
    ) { }

    public function create(): BotUser
    {
        $user = BotUser::create([
            'bot_id' => $this->bot_id,
            'chat_id' => $this->chat_id,
            'first_name' => base64_encode($this->first_name),
            'username' => base64_encode($this->username)
        ]);

        event(new BotUserCreated($user));

        return $user;
    }
}
