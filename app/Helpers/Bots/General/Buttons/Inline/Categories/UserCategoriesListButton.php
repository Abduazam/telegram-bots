<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Categories;

use App\Models\Bots\General\Users\BotUser;
use App\Models\Bots\Taskable\Categories\TaskableCategory;
use App\Repository\Bots\Models\Taskable\Categories\TaskableCategoryRepository;

class UserCategoriesListButton
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
        $categories = TaskableCategory::select('taskable_categories.id', 'taskable_categories.title')
            ->leftJoin('taskable_inactive_categories', 'taskable_categories.id', '=', 'taskable_inactive_categories.taskable_category_id')
            ->selectRaw('CASE WHEN taskable_inactive_categories.id IS NOT NULL THEN true ELSE false END AS disabled')
            ->whereNull('taskable_categories.bot_user_id')
            ->orWhere('taskable_categories.bot_user_id', $this->user->id)
            ->orderBy('taskable_categories.id')
            ->get()
            ->toArray();

        if (empty($categories)) {
            $inlineKeyboard = [];

            foreach ($this->additionalButtons as $additionalButton) {
                $inlineKeyboard[] = $additionalButton;
            }

            return [
                'text' => __('telegram.response.empty', ['model' => __('taskable.sections.my-categories.text')]),
                'keyboard' => $inlineKeyboard,
            ];
        }

        $index = 1;
        $textCategories = '';
        $inlineKeyboard = [];

        foreach (array_chunk($categories, 4) as $categoryGroup) {
            $inlineButtons = [];

            foreach ($categoryGroup as $category) {
                $categoryDescription = base64_decode($category['title']);

                if ($category['disabled']) {
                    $textCategories .= "{$index}. $categoryDescription ❌\n";
                } else {
                    $textCategories .= "{$index}. $categoryDescription\n";
                }

                $inlineButtons[] = [
                    'text' => $index,
                    'callback_data' => $category['id'],
                ];

                $index++;
            }

            $inlineKeyboard[] = $inlineButtons;
        }

        $textCategories = "<b>" . __('taskable.sections.my-categories.text') . "</b>\n\n". $textCategories;

        foreach ($this->additionalButtons as $additionalButton) {
            $inlineKeyboard[] = $additionalButton;
        }

        return [
            'text' => $textCategories,
            'keyboard' => $inlineKeyboard,
        ];
    }
}
