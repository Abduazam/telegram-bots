<?php

namespace App\Services\Bots\Models\BotUsers;

use App\Models\Bots\Telegram\Telegram;
use App\Models\Bots\Users\BotUser;

class BotUserFindService
{
    protected int $chat_id;
    protected string $first_name;
    protected ?string $username;

    public function __construct(Telegram $telegram) {
        $this->chat_id = $telegram->ChatID();
        $this->first_name = $telegram->FirstName();
        $this->username = $telegram->Username();
    }

    public function find(): BotUser
    {
        $user = BotUser::where('chat_id', $this->chat_id)->first();
        if ($user) {
            // (new BotUserUpdateService($this->chat_id, $this->first_name, $this->username))->update();
            return $user;
        }

        return (new BotUserCreateService($this->chat_id, $this->first_name, $this->username))->create();
    }
}
