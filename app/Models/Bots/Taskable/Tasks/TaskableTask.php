<?php

namespace App\Models\Bots\Taskable\Tasks;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bots\General\Users\BotUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Bots\Taskable\Categories\TaskableCategory;
use App\Models\Bots\Taskable\Tasks\Traits\TaskableTaskMethods;
use PhpParser\Builder\Function_;

/**
 * Table columns
 * @property int $id
 * @property int $bot_user_id
 * @property int $taskable_category_id
 * @property string $description
 * @property int $amount
 * @property string $schedule_time
 * @property boolean $active
 *
 * Relations
 * @property BelongsTo $user
 * @property BelongsTo $category
 */
class TaskableTask extends Model
{
    use HasFactory, SoftDeletes;
    use TaskableTaskMethods;

    const NULL_SCHEDULE_TIME = '00:00:01';

    protected $fillable = [
        'bot_user_id',
        'taskable_category_id',
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
        return $this->belongsTo(TaskableCategory::class, 'taskable_category_id');
    }
}
