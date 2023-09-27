<?php

namespace App\Services\Bots\Models\Categories\BotUserCategories;

use App\Models\Bots\Categories\BotUserCategory;
use App\Models\Bots\Users\BotUser;

class BotUserCategoryCreateService
{
    public function __construct(
        protected BotUser $user,
        protected string $text,
    ) { }

    public function __invoke(): void
    {
        BotUserCategory::create([
            'bot_user_id' => $this->user->id,
            'translation' => base64_encode($this->text)
        ]);
    }
}
