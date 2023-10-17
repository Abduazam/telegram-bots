<?php

namespace App\Contracts\Enums\Bots\Models\BotUsers;

enum BotUserActiveEnum : int
{
    case INACTIVE = 0;
    case ACTIVE = 1;
    case BLOCKED = 2;
}
