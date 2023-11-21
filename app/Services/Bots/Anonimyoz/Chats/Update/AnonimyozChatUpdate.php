<?php

namespace App\Services\Bots\Anonimyoz\Chats\Update;

use Exception;
use App\Models\Bots\General\Users\BotUser;
use App\Models\Bots\Anonimyoz\Chat\AnonimyozChat;

class AnonimyozChatUpdate
{
    public function __construct(protected AnonimyozChat $chat, protected BotUser $receiver) { }

    public function __invoke(): bool
    {
        try {
            $this->chat->update([
                'receiver_id' => $this->receiver->id,
            ]);

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }
}
