<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Models\Bots\Users\BotUser;
use App\Helpers\Bots\General\Texts\GetTextTranslations;
use App\Helpers\Bots\General\Buttons\Inline\Actions\BackButton;
use App\Helpers\Bots\General\Buttons\Inline\Tasks\UserTasksButton;
use App\Helpers\Bots\General\Buttons\Inline\Tasks\UserAddTaskButton;
use App\Helpers\Bots\General\Buttons\Inline\Categories\UserCategoriesButton;
use App\Helpers\Bots\General\Buttons\Inline\Categories\UserAddCategoryButton;

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
                        ['text' => GetTextTranslations::getTextTranslation('my-tasks-button'), 'callback_data' => 'my-tasks-button'],
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

    public static function myTasksSectionMessage(BotUser $user): array
    {
        $additionalButtons = [
            [
                (new BackButton())(),
                (new UserAddTaskButton())(),
            ],
        ];

        $response = (new UserTasksButton($user, $additionalButtons))();

        return [
            'chat_id' => $user->chat_id,
            'text' => $response['text'],
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => $response['keyboard']
            ])
        ];
    }
}
