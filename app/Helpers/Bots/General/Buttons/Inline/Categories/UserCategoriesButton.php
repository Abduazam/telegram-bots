<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Categories;

use App\Models\Bots\General\Users\BotUser;
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
        $categories = $this->repository->getBotCategories()->toArray();
        $userCategories = $this->repository->getUserBotCategories($this->user->id)->toArray();

        $allCategories = array_merge($categories, $userCategories);

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
