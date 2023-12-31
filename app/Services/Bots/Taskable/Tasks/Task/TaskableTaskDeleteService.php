<?php

namespace App\Services\Bots\Taskable\Tasks\Task;

use App\Models\Bots\Taskable\Tasks\TaskableTask;
use Exception;
use Illuminate\Support\Facades\DB;

class TaskableTaskDeleteService
{
    public function __construct(protected TaskableTask $task) { }

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
