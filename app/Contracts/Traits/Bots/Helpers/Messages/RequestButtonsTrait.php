<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

trait RequestButtonsTrait
{
    public static function phoneNumberRequest(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => GetTextTranslations::getTextTranslation('request-phone-number-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        [
                            'text' => GetTextTranslations::getTextTranslation('request-phone-number-button'),
                            'request_contact' => true
                        ],
                    ],
                ],
                'resize_keyboard' => true
            ])
        ];
    }

    public static function locationRequest(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => GetTextTranslations::getTextTranslation('request-location-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        [
                            'text' => GetTextTranslations::getTextTranslation('request-location-button'),
                            'request_location' => true
                        ],
                    ],
                ],
                'resize_keyboard' => true
            ])
        ];
    }
}
