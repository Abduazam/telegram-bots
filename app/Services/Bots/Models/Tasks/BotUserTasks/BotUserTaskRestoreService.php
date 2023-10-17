<?php

namespace App\Services\Bots\Models\Tasks\BotUserTasks;

use Mockery\Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Bots\Tasks\BotUserTask;

class BotUserTaskRestoreService
{
    public function __construct(protected BotUserTask $task) { }

    public function restore(): bool
    {
        try {
            DB::beginTransaction();

            $this->task->restore();

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            info($exception);
            return false;
        }
    }
}
