<?php

namespace App\Contracts\Enums\Bots\General;

enum BotCategoriesTypeEnum : string
{
    case BOT_CATEGORY = 'bot_categories';
    case BOT_USER_CATEGORY = 'bot_user_categories';
}
