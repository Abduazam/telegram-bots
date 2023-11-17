<?php

namespace App\Helpers\Bots\General\Buttons\Inline\Categories;

class UserAddCategoryButton
{
    public function __invoke(): array
    {
        return ['text' => __('taskable.sections.add-task.add-category.button'), 'callback_data' => 'add-category-button'];
    }
}
