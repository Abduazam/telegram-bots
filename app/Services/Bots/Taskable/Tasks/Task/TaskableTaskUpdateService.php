<?php

namespace App\Services\Bots\Taskable\Tasks\Task;

use App\Models\Bots\Taskable\Tasks\TaskableTask;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class TaskableTaskUpdateService
{
    public function __construct(protected TaskableTask $task) { }

    public function updateTaskCategory(int $category_id): bool
    {
        try {
            DB::beginTransaction();

            $this->task->update([
                'taskable_category_id' => $category_id,
            ]);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            info($exception);
            return false;
        }
    }

    public function updateTaskDescription(string $text): bool
    {
        try {
            DB::beginTransaction();

            $this->task->update([
                'description' => base64_encode($text),
            ]);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            info($exception);
            return false;
        }
    }

    public function updateTaskAmount(int $amount): bool
    {
        try {
            DB::beginTransaction();

            $this->task->update([
                'amount' => $amount,
            ]);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            info($exception);
            return false;
        }
    }

    public function updateTaskSchedule(string $schedule_time): bool
    {
        try {
            DB::beginTransaction();

            $this->task->update([
                'schedule_time' => $schedule_time,
            ]);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            info($exception);
            return false;
        }
    }

    public function updateTaskActive(bool $active): bool
    {
        try {
            DB::beginTransaction();

            $this->task->update([
                'active' => $active,
            ]);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            info($exception);
            return false;
        }
    }
}
