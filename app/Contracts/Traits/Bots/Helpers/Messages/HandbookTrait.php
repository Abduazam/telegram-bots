<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Helpers\Bots\General\Buttons\BackButton;
use App\Helpers\Bots\General\Texts\GetTextTranslations;

trait HandbookTrait
{
    public static function handbookMessage(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => "Ҳозир қўлланма мавжуд эмас",
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        (new BackButton())()
                    ],
                ],
            ])
        ];
    }
}
