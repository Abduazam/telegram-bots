<?php

namespace App\Services\Bots\Models\BotUsers;

use App\Models\Bots\Users\BotUser;

class BotUserUpdateService
{
    public function __construct(
        protected int $chat_id,
        protected string $first_name,
        protected ?string $username,
    ) { }

    public function update(): void
    {
        BotUser::where('chat_id', $this->chat_id)->update([
            'first_name' => base64_encode($this->first_name),
            'username' => base64_encode($this->username)
        ]);
    }
}
