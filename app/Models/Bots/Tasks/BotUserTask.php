<?php

namespace App\Models\Bots\Tasks;

use App\Models\Bots\Categories\BotCategory;
use App\Models\Bots\Users\BotUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $bot_user_id
 * @property int $bot_category_id
 * @property string $description
 * @property int $amount
 * @property string $schedule_time
 * @property boolean $active
 */
class BotUserTask extends Model
{
    use HasFactory, SoftDeletes;

    const NULL_SCHEDULE_TIME = '00:00:01';

    protected $fillable = [
        'bot_user_id',
        'bot_category_id',
        'description',
        'amount',
        'schedule_time',
        'active',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(BotUser::class, 'bot_user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BotCategory::class, 'bot_category_id');
    }

    public function getDescription(): bool|string
    {
        return base64_decode($this->description);
    }

    public function getScheduleTime(): ?string
    {
        return $this->schedule_time != self::NULL_SCHEDULE_TIME ? date('H:i', strtotime($this->schedule_time)) : null;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function isChanging(string $field): bool
    {
        return !is_null($this->{$field});
    }

    public function files(): HasMany
    {
        return $this->hasMany(BotUserTaskFile::class);
    }
}
