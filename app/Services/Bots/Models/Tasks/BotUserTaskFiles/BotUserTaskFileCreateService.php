<?php

namespace App\Services\Bots\Models\Tasks\BotUserTaskFiles;

use App\Contracts\Enums\Bots\General\FileTypeEnum;
use App\Models\Bots\Tasks\BotUserTask;
use App\Models\Bots\Tasks\BotUserTaskFile;
use App\Models\Bots\Users\BotUser;
use App\Models\Bots\Users\BotUserLog;

class BotUserTaskFileCreateService
{
    protected BotUserTask $task;
    protected string $file_id;

    public function __construct(BotUser $user, string $file_id)
    {
        $this->file_id = $file_id;

        $log = BotUserLog::where('bot_user_id', $user->id)->first();
        $this->task = BotUserTask::where('bot_user_id', $user->id)->where('id', $log->bot_user_task_id)->first();
    }

    public function createPhotoTask(): void
    {
        BotUserTaskFile::create([
            'bot_user_task_id' => $this->task->id,
            'file_id' => $this->file_id,
            'file_type' => FileTypeEnum::PHOTO->value,
        ]);
    }

    public function createVideoTask(): void
    {
        BotUserTaskFile::create([
            'bot_user_task_id' => $this->task->id,
            'file_id' => $this->file_id,
            'file_type' => FileTypeEnum::VIDEO->value,
        ]);
    }

    public function createVoiceTask(): void
    {
        BotUserTaskFile::create([
            'bot_user_task_id' => $this->task->id,
            'file_id' => $this->file_id,
            'file_type' => FileTypeEnum::VOICE->value,
        ]);
    }

    public function createAudioTask(): void
    {
        BotUserTaskFile::create([
            'bot_user_task_id' => $this->task->id,
            'file_id' => $this->file_id,
            'file_type' => FileTypeEnum::AUDIO->value,
        ]);
    }

    public function createFileTask(): void
    {
        BotUserTaskFile::create([
            'bot_user_task_id' => $this->task->id,
            'file_id' => $this->file_id,
            'file_type' => FileTypeEnum::FILE->value,
        ]);
    }
}
