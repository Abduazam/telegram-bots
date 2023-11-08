<?php

namespace App\Contracts\Traits\Bots\Helpers\Messages;

use App\Helpers\Bots\General\Buttons\Inline\Actions\BackButton;
use App\Helpers\Bots\General\Texts\GetTextTranslations;

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
}
