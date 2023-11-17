<?php

namespace App\Models\Bots\Taskable\Categories\Traits;

use App\Models\Bots\Taskable\Categories\TaskableInactiveCategory;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait TaskableCategoryMethods
{
    /**
     * BotCategory model attribute getters.
     */
    public function getTitle(): bool|string
    {
        return base64_decode($this->title);
    }

    public function inactive(int $user_id): bool
    {
        return $this->hasOne(TaskableInactiveCategory::class, 'taskable_category_id')->where('bot_user_id', $user_id)->exists();
    }
}
