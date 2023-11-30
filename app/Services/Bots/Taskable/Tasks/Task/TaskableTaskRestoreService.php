<?php

namespace App\Services\Bots\Taskable\Tasks\Task;

use App\Models\Bots\Taskable\Tasks\TaskableTask;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class TaskableTaskRestoreService
{
    public function __construct(protected TaskableTask $task) { }

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
