<?php

namespace App\Helpers\Bots\General\Buttons\Categories;

use App\Models\Bots\Categories\BotCategory;
use App\Models\Bots\Categories\BotUserCategory;
use App\Models\Bots\Users\BotUser;

class UserCategoriesButton
{
    public function __construct(
        protected array $additionalButtons = [],
        protected ?BotUser $user = null,
    ) { }

    public function __invoke(): array
    {
        $categories = BotCategory::with('translation')->get()->toArray();

        $userCategories = [];
        if (!is_null($this->user)) {
            $userCategories = $this->user->categories->toArray();
        }

        $allCategories = array_merge($categories, $userCategories);

        if (count($allCategories) > 0) {
            $chunkedCategories = array_chunk($allCategories, 3);

            $inlineKeyboard = [];

            foreach ($chunkedCategories as $categoryGroup) {
                $inlineButtons = [];

                foreach ($categoryGroup as $category) {

                    $inlineButtons[] = [
                        'text' => array_key_exists('bot_user_id', $category) ? base64_decode($category['translation']) : base64_decode($category['translation']['translation']),
                        'callback_data' => array_key_exists('bot_user_id', $category) ? 'user_category_' . $category['id'] : 'category_' . $category['id'],
                    ];
                }

                $inlineKeyboard[] = $inlineButtons;
            }

            foreach ($this->additionalButtons as $additionalButton) {
                $inlineKeyboard[] = $additionalButton;
            }

            return $inlineKeyboard;
        }

        return [];
    }
}
