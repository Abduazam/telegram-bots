<?php

namespace App\Models\Bots\Taskable\Categories\Traits;

trait TaskableCategoryMethods
{
    /**
     * BotCategory model attribute getters.
     */
    public function getTitle(): bool|string
    {
        return base64_decode($this->title);
    }
}
