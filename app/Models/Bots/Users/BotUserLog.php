<?php

namespace App\Models\Bots\Users;

use App\Models\Bots\Tasks\BotUserTask;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bots\Categories\BotCategory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $bot_user_id
 * @property int $bot_category_id
 * @property int $bot_user_task_id
 */
class BotUserLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'bot_user_id',
        'bot_category_id',
        'bot_user_task_id',
    ];

    /**
     * BotUserLog model relations.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(BotUser::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BotCategory::class, 'bot_category_id');
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(BotUserTask::class, 'bot_user_task_id');
    }
}
