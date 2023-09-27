<?php

namespace App\Helpers\Bots\General\Rules;

class TaskScheduleTimeCheckRule
{
    public function __construct(protected string $text) { }

    public function __invoke(): bool
    {
        return preg_match('/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/', $this->text) === 1;
    }
}
