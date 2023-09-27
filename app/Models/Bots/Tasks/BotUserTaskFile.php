<?php

namespace App\Models\Bots\Tasks;

use App\Contracts\Enums\Bots\General\FileTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $bot_user_task_id
 * @property string $file_id
 * @property string $file_type
 */
class BotUserTaskFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'bot_user_task_id',
        'file_id',
        'file_type',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(BotUserTask::class);
    }

    public function isAudioType(): bool
    {
        return $this->file_type === FileTypeEnum::AUDIO->value;
    }

    public function isVoiceType(): bool
    {
        return $this->file_type === FileTypeEnum::VOICE->value;
    }

    public function isPhotoType(): bool
    {
        return $this->file_type === FileTypeEnum::PHOTO->value;
    }

    public function isVideoType(): bool
    {
        return $this->file_type === FileTypeEnum::VIDEO->value;
    }

    public function isFileType(): bool
    {
        return $this->file_type === FileTypeEnum::FILE->value;
    }
}
