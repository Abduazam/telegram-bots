<?php

namespace App\Services\Bots\Taskable\Categories\InactiveCategory;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Bots\General\Users\BotUser;
use App\Models\Bots\Taskable\Categories\TaskableInactiveCategory;

class TaskableInactiveCategoryCreateService
{
    public function __construct(protected BotUser $user) { }

    public function __invoke(): bool
    {
        try {
            DB::transaction(function () {
                TaskableInactiveCategory::create([
                    'bot_user_id' => $this->user->id,
                    'taskable_category_id' => $this->user->taskable_log->taskable_category_id,
                ]);
            }, 5);

            return true;
        } catch (Exception $exception) {
            info($exception);
            return false;
        }
    }
}
