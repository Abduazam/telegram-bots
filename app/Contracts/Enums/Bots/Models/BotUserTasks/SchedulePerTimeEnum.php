<?php

namespace App\Contracts\Enums\Bots\Models\BotUserTasks;

enum SchedulePerTimeEnum : string
{
    case ALL_DAYS = 'all-days';
    case ODD_DAYS = 'odd-days';
    case EVEN_DAYS = 'even-days';
    case WEEK_DAYS = 'week_days';
    case CUSTOM_DAYS = 'custom_days';
}
