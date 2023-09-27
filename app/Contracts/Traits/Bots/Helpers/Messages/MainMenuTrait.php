<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

trait MainMenuTrait
{
    public static function mainMenu(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => GetTextTranslations::getTextTranslation('main-menu-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => GetTextTranslations::getTextTranslation('my-tasks-button'), 'callback_data' => 'my-tasks-button'],
                        ['text' => GetTextTranslations::getTextTranslation('add-tasks-button'), 'callback_data' => 'add-tasks-button']
                    ],
                    [
                        ['text' => GetTextTranslations::getTextTranslation('handbook-button'), 'callback_data' => 'handbook-button']
                    ],
                ],
            ])
        ];
    }
}
