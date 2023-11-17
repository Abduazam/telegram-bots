<?php

namespace App\Services\Bots\Taskable\Logs;


use App\Models\Bots\Taskable\Logs\TaskableLog;

class TaskableLogUpdateService
{
    public function __construct(protected TaskableLog $log) { }

    public function updateCategoryId(int $category_id): void
    {
        $this->log->update([
            'taskable_category_id' => $category_id,
        ]);
    }

    public function updateTaskId(int $task_id): void
    {
        $this->log->update([
            'taskable_task_id' => $task_id,
        ]);
    }

    public function updateSectionName(string $section_name): void
    {
        $this->log->update([
            'section_name' => $section_name,
        ]);
    }
}
