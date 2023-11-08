<?php

namespace App\Models\Bots\Taskable\Logs;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bots\General\Users\BotUser;
use App\Models\Bots\Taskable\Tasks\TaskableTask;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Bots\Taskable\Categories\TaskableCategory;

/**
 * Table columns
 * @property int $bot_user_id
 * @property int $taskable_category_id
 * @property int $taskable_task_id
 *
 * Relations
 * @property BelongsTo $user
 * @property BelongsTo $category
 * @property TaskableTask $task
 */
class TaskableLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'bot_user_id',
        'taskable_category_id',
        'taskable_task_id',
    ];

    /**
     * BotUserLog model relations.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(BotUser::class, 'bot_user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TaskableCategory::class, 'taskable_category_id');
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(TaskableTask::class, 'taskable_task_id')->withTrashed();
    }
}
