<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Models\Bots\General\Users\BotUser;
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
            'text' => __('taskable.main.welcome'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => __('taskable.sections.my-tasks.text'), 'callback_data' => 'my-tasks'],
                        ['text' => __('taskable.sections.add-task.text'), 'callback_data' => 'add-task']
                    ],
                    [
                        ['text' => __('telegram.sections.settings'), 'callback_data' => 'settings'],
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
            'text' => __('taskable.sections.add-task.choose-categories'),
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

    public static function settingsSectionMessage(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => __('taskable.sections.settings.text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => __('telegram.sections.handbook'), 'callback_data' => 'handbook'],
                        ['text' => __('taskable.sections.settings.tariff-plan'), 'callback_data' => 'tariff-plan']
                    ],
                    [
                        (new BackButton())(),
                    ],
                ]
            ])
        ];
    }
}
