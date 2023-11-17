<?php

namespace App\Services\Bots\Taskable\Categories\InactiveCategory;

use App\Models\Bots\General\Users\BotUser;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Bots\Taskable\Categories\TaskableInactiveCategory;

class TaskableInactiveCategoryDeleteService
{
    protected TaskableInactiveCategory $category;

    public function __construct(BotUser $user, int $category_id)
    {
        $this->category = TaskableInactiveCategory::where('bot_user_id', $user->id)->where('taskable_category_id', $category_id)->first();
    }

    public function __invoke(): bool
    {
        try {
            DB::transaction(function () {
                $this->category->delete();
            }, 5);

            return true;
        } catch (Exception $exception) {
            info($exception);
            return false;
        }
    }
}
