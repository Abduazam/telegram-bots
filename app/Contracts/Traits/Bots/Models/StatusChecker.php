<?php

namespace App\Contracts\Traits\Bots\Models;

trait StatusChecker
{
    public function isInactive(): bool
    {
        return $this->active === 0;
    }

    public function isActive(): bool
    {
        return $this->active === 1;
    }

    public function isBlocked(): bool
    {
        return $this->active === 2;
    }
}
