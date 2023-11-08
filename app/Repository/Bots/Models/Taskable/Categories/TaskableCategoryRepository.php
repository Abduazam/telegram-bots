<?php

namespace App\Repository\Bots\Models\Taskable\Categories;

use App\Models\Bots\Taskable\Categories\TaskableCategory;

class TaskableCategoryRepository
{
    public function getBotCategories()
    {
        return TaskableCategory::whereNull('bot_user_id')->get();
    }

    public function getUserBotCategories(int $user_id)
    {
        return TaskableCategory::where('bot_user_id', $user_id)->get();
    }

    public function find(int $id)
    {
        return TaskableCategory::find($id);
    }
}
