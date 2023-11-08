<?php

namespace App\Models\Bots\Taskable\Tasks\Traits;

trait TaskableTaskMethods
{
    public function getDescription(): bool|string
    {
        return base64_decode($this->description);
    }

    public function getScheduleTime(): ?string
    {
        return $this->schedule_time != self::NULL_SCHEDULE_TIME ? date('H:i', strtotime($this->schedule_time)) : null;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function isChanging(string $field): bool
    {
        return !is_null($this->{$field});
    }
}
