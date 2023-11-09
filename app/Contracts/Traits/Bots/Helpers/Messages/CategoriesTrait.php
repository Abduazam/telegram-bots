<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Models\Bots\General\Users\BotUser;
use App\Helpers\Bots\General\Buttons\Inline\Actions\BackButton;
use App\Helpers\Bots\General\Buttons\Inline\Categories\UserAddCategoryButton;

trait CategoriesTrait
{
    public static function addUserCategoryMessage(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => __('taskable.sections.add-task.add-category.text'),
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

    public static function getAllCategorySectionMessage(BotUser $user): array
    {
        $additionalButtons = [
            [
                (new BackButton())(),
                (new UserAddCategoryButton())(),
            ],
        ];

        return [
            'chat_id' => $user->chat_id,
            'text' => __('taskable.sections.add-task.settings.all-category-text'),
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => (new UserCategoriesListButton($user, $additionalButtons))()
            ])
        ];
    }
}
