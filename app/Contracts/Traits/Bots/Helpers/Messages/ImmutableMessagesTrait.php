<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Helpers\Bots\General\Buttons\Inline\Actions\BackButton;
use App\Helpers\Bots\General\Buttons\Inline\Categories\UserAddCategoryButton;
use App\Helpers\Bots\General\Buttons\Inline\Categories\UserCategoriesButton;
use App\Helpers\Bots\General\Texts\GetTextTranslations;
use App\Models\Bots\Users\BotUser;

trait ImmutableMessagesTrait
{
    public static function mainMenuMessage(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => GetTextTranslations::getTextTranslation('main-menu-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => GetTextTranslations::getTextTranslation('add-tasks-button'), 'callback_data' => 'add-tasks-button']
                    ],
                ],
            ])
        ];
    }

    public static function addTasksSectionMessage(BotUser $user): array
    {
        $additionalButtons = [
            [
                (new BackButton())(),
                (new UserAddCategoryButton())(),
            ],
        ];

        return [
            'chat_id' => $user->chat_id,
            'text' => GetTextTranslations::getTextTranslation('user-choose-category-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => (new UserCategoriesButton($user, $additionalButtons))()
            ])
        ];
    }
}
