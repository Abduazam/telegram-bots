<?php

namespace App\Services\Bots\Anonimyoz\Chats\Create;

use Exception;
use App\Models\Bots\General\Users\BotUser;
use App\Models\Bots\Anonimyoz\Chat\AnonimyozChat;
use App\Services\Bots\Anonimyoz\Chats\Update\AnonimyozChatUpdate;

class AnonimyozChatCreate
{
    protected BotUser $sender;
    protected ?BotUser $receiver;

    public function __construct(BotUser $sender, $receiver)
    {
        $this->sender = $sender;
        if (is_numeric($receiver)) {
            $this->receiver = BotUser::findOrFail($receiver);
        } else {
            $chat = AnonimyozChat::with('sender')->where('sender_username', $receiver)->first();
            $this->receiver = $chat->sender;
        }
    }

    public function __invoke(): bool
    {
        $chat = AnonimyozChat::where('sender_id', $this->sender->id)->first();
        if ($chat) {
            if (is_null($this->receiver)) {
                return false;
            }

            return (new AnonimyozChatUpdate($chat, $this->receiver))();
        } else {
            try {
                AnonimyozChat::create([
                    'sender_id' => $this->sender->id,
                    'receiver_id' => $this->receiver->id,
                ]);

                return true;
            } catch (Exception $exception) {
                return false;
            }
        }
    }
}
