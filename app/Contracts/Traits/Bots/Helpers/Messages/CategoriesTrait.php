<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Models\Bots\General\Users\BotUser;
use App\Models\Bots\Taskable\Categories\TaskableCategory;
use App\Helpers\Bots\General\Buttons\Inline\Actions\BackButton;
use App\Helpers\Bots\General\Buttons\Inline\Actions\ChangeButton;
use App\Helpers\Bots\General\Buttons\Inline\Tasks\ForceDeleteButton;
use App\Helpers\Bots\General\Buttons\Inline\Categories\CategoryDeleteRestoreButton;

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

    public static function getCategoryMessage(BotUser $user, int $id): array
    {
        $category = TaskableCategory::findOrFail($id);

        $userIsBotUser = ($user->id === $category->bot_user_id);

        $keyboard = [
            ...(($userIsBotUser) ? [(new ForceDeleteButton())()] : []),
            (new CategoryDeleteRestoreButton())($category, $user->id),
        ];

        $keyboard2 = [
            ...(($userIsBotUser) ? [(new ChangeButton())()] : []),
            (new BackButton())(),
        ];

        return [
            'chat_id' => $user->chat_id,
            'text' => "<b>" . __('taskable.items.category.title') . ":</b> {$category->getTitle()}\n<b>" . __('taskable.items.category.tasks-count') . ":</b> {$category->tasks($user->id)->count()}",
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    $keyboard,
                    $keyboard2,
                ],
            ])
        ];
    }

    public static function getCategoryChangeMessage(int $chat_id): array
    {
        return [
            'chat_id' => $chat_id,
            'text' => __('taskable.sections.my-categories.changing-category.title'),
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
