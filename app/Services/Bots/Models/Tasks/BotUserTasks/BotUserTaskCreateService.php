<?php

namespace App\Services\Bots\Models\Tasks\BotUserTasks;

use App\Models\Bots\Users\BotUser;
use App\Models\Bots\Tasks\BotUserTask;
use App\Services\Bots\Models\BotUserLogs\BotUserLogUpdateService;
use Exception;
use Illuminate\Support\Facades\DB;

class BotUserTaskCreateService
{
    public function __construct(
        protected BotUser $user,
    ) { }

    public function createTaskDescription(string $text): bool
    {
        try {
            DB::beginTransaction();

            $task = BotUserTask::create([
                'bot_user_id' => $this->user->id,
                'bot_category_id' => $this->user->log->bot_category_id,
                'description' => base64_encode($text),
            ]);

            (new BotUserLogUpdateService($this->user->log))->updateTaskId($task->id);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            info($exception);
            return false;
        }
    }
}
