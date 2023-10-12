<?php

namespace App\Repository\Bots\Models\BotCategory;

use App\Models\Bots\Categories\BotCategory;

class BotCategoryRepository
{
    public function getBotCategories()
    {
        return BotCategory::whereNull('bot_user_id')->get();
    }

    public function getUserBotCategories(int $user_id)
    {
        return BotCategory::where('bot_user_id', $user_id)->get();
    }

    public function find(int $id)
    {
        return BotCategory::find($id);
    }
}
