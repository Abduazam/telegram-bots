<?php

namespace App\Services\Bots\Taskable\Tasks\Track;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Bots\General\Users\BotUser;
use App\Models\Bots\Taskable\Tasks\TaskableTaskTrack;

class TaskableTaskTrackCreateService
{
    public function __construct(
        protected BotUser $user,
        protected int $count,
    ) { }

    public function __invoke(): bool
    {
        try {
            DB::beginTransaction();

            TaskableTaskTrack::create([
                'taskable_task_id' => $this->user->taskable_log->taskable_task_id,
                'amount' => $this->count,
            ]);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            return false;
        }
    }
}
