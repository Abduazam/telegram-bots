<?php

namespace App\Services\Bots\Models\BotUsers;

use App\Events\Bots\BotUsers\BotUserCreated;
use App\Models\Bots\Users\BotUser;

class BotUserCreateService
{
    public function __construct(
        protected int $chat_id,
        protected string $first_name,
        protected ?string $username,
    ) { }

    public function create(): BotUser
    {
        $user = BotUser::create([
            'chat_id' => $this->chat_id,
            'first_name' => base64_encode($this->first_name),
            'username' => base64_encode($this->username)
        ]);

        event(new BotUserCreated($user));

        return $user;
    }
}
