<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

trait RequestButtonsTrait
{
    public static function phoneNumberRequest(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => __('telegram.request.phone-number-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        [
                            'text' => __('telegram.request.phone-number-button'),
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
            'text' => __('telegram.request.location-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        [
                            'text' => __('telegram.request.location-button'),
                            'request_location' => true
                        ],
                    ],
                ],
                'resize_keyboard' => true
            ])
        ];
    }
}
