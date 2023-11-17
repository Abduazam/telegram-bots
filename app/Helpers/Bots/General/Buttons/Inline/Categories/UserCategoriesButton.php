<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Categories;

use App\Models\Bots\General\Users\BotUser;
use App\Models\Bots\Taskable\Categories\TaskableCategory;
use App\Repository\Bots\Models\Taskable\Categories\TaskableCategoryRepository;

class UserCategoriesButton
{
    protected TaskableCategoryRepository $repository;

    public function __construct(
        protected BotUser $user,
        protected array $additionalButtons,
    ) {
        $this->repository = new TaskableCategoryRepository();
    }

    public function __invoke(): array
    {
        $user_id = $this->user->id;

        $allCategories = TaskableCategory::select('id', 'title')
            ->whereNotIn('id', function ($query) use ($user_id) {
                $query->select('taskable_category_id')
                    ->from('taskable_inactive_categories')
                    ->where('bot_user_id', $user_id);
            })
            ->whereNull('bot_user_id')
            ->orWhere('bot_user_id', $this->user->id)
            ->get()
            ->toArray();

        if (count($allCategories) > 0) {
            $chunkedCategories = array_chunk($allCategories, 3);

            $inlineKeyboard = [];

            foreach ($chunkedCategories as $categoryGroup) {
                $inlineButtons = [];

                foreach ($categoryGroup as $category) {

                    $inlineButtons[] = [
                        'text' => base64_decode($category['title']),
                        'callback_data' => $category['id'],
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
