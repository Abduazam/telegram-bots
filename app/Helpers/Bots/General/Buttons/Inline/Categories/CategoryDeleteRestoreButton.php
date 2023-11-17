<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Categories;

use App\Models\Bots\Taskable\Categories\TaskableCategory;

class CategoryDeleteRestoreButton
{
    public function __invoke(TaskableCategory $category, int $user_id): array
    {
        if ($category->inactive($user_id)) {
            return ['text' => __('telegram.crud.restore'), 'callback_data' => 'restore-button'];
        }

        return ['text' => __('telegram.crud.delete'), 'callback_data' => 'delete-button'];
    }
}
