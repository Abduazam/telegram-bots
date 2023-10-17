<?php

namespace App\Services\Bots\Models\Tasks\BotUserTasks;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Bots\Tasks\BotUserTask;
use App\Events\Bots\BotUserLog\UpdateBotUserLogToNull;

class BotUserTaskDeleteService
{
    public function __construct(protected BotUserTask $task) { }

    public function delete(): bool
    {
        try {
            DB::beginTransaction();

            $this->task->delete();

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            info($exception);
            return false;
        }
    }

    public function forceDelete(): bool
    {
        try {
            DB::beginTransaction();

            $this->task->forceDelete();

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            info($exception);
            return false;
        }
    }
}
