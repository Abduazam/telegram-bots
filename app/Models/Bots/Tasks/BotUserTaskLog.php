<?php

namespace App\Models\Bots\Tasks;

use App\Models\Bots\Categories\BotCategory;
use App\Models\Bots\Categories\BotUserCategory;
use App\Models\Bots\Users\BotUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $bot_user_id
 * @property int $bot_category_id
 * @property int $bot_user_category_id
 * @property int $bot_user_task_id
 */
class BotUserTaskLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'bot_user_id',
        'bot_category_id',
        'bot_user_category_id',
        'bot_user_task_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(BotUser::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BotCategory::class);
    }

    public function user_category(): BelongsTo
    {
        return $this->belongsTo(BotUserCategory::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(BotUserTask::class);
    }

    public function isBotCategory(): bool
    {
        return !is_null($this->bot_category_id);
    }

    public function isBotUserCategory(): bool
    {
        return !is_null($this->bot_user_category_id);
    }
}
