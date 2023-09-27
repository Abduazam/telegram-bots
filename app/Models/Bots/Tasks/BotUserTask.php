<?php

namespace App\Models\Bots\Tasks;

use App\Models\Bots\Categories\BotCategory;
use App\Models\Bots\Categories\BotUserCategory;
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
 * @property int $bot_user_category_id
 * @property string $description
 * @property string $schedule_time
 * @property boolean $active
 */
class BotUserTask extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bot_user_id',
        'bot_category_id',
        'bot_user_category_id',
        'description',
        'amount',
        'schedule_time',
        'active',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(BotUser::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BotCategory::class, 'id');
    }

    public function user_category(): BelongsTo
    {
        return $this->belongsTo(BotUserCategory::class);
    }

    public function getDescription(): bool|string
    {
        return base64_decode($this->description);
    }

    public function getScheduleTime(): string
    {
        return date('H:i', strtotime($this->schedule_time));
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function files(): HasMany
    {
        return $this->hasMany(BotUserTaskFile::class);
    }
}
