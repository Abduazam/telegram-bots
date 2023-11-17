<?php

namespace App\Services\Bots\Taskable\Categories\Category;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Bots\General\Users\BotUser;

class TaskableCategoryUpdateService
{
    public function __construct(
        protected BotUser $user,
        protected string $text,
    ) { }

    public function __invoke(): bool
    {
        try {
            DB::beginTransaction();

            $this->user->taskable_log->category->update([
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
