<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Helpers\Bots\General\Texts\GetTextTranslations;

trait AuthenticationTrait
{
    public static function authenticatedSuccessfully(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => __('telegram.auth.succeed'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'remove_keyboard' => true
            ])
        ];
    }

    public static function authenticatedFailed(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => __('telegram.auth.failed'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'remove_keyboard' => true
            ])
        ];
    }
}
