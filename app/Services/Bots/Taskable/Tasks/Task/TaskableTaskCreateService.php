<?php

namespace App\Services\Bots\Taskable\Tasks\Task;

use App\Models\Bots\General\Users\BotUser;
use App\Models\Bots\Taskable\Tasks\TaskableTask;
use App\Services\Bots\Taskable\Logs\TaskableLogUpdateService;
use Exception;
use Illuminate\Support\Facades\DB;

class TaskableTaskCreateService
{
    public function __construct(
        protected BotUser $user,
    ) { }

    public function createTaskDescription(string $text): bool
    {
        try {
            DB::beginTransaction();

            $task = TaskableTask::create([
                'bot_user_id' => $this->user->id,
                'taskable_category_id' => $this->user->taskable_log->taskable_category_id,
                'description' => base64_encode($text),
            ]);

            (new TaskableLogUpdateService($this->user->taskable_log))->updateTaskId($task->id);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            return false;
        }
    }
}
