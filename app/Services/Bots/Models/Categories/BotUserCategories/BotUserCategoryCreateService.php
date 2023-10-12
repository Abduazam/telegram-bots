<?php

namespace App\Services\Bots\Models\Categories\BotUserCategories;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Bots\Users\BotUser;
use App\Models\Bots\Categories\BotCategory;

class BotUserCategoryCreateService
{
    public function __construct(
        protected BotUser $user,
        protected string $text,
    ) { }

    public function __invoke(): bool
    {
        try {
            DB::beginTransaction();

            BotCategory::create([
                'bot_user_id' => $this->user->id,
                'slug' => Str::slug($this->text),
                'title' => base64_encode($this->text)
            ]);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            info($exception);
            return false;
        }
    }
}
