<?php

namespace App\Models\Bots\Taskable\Tasks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Table columns
 * @property int $id
 * @property int $taskable_task_id
 * @property int $amount
 * @property string $created_date
 *
 * Relations
 * @property BelongsTo $taskable_task
 */
class TaskableTaskTrack extends Model
{
    use HasFactory;

    protected $fillable = [
        'taskable_task_id',
        'amount',
        'created_date',
    ];

    public function taskable_task(): BelongsTo
    {
        return $this->belongsTo(TaskableTask::class, 'taskable_task_id');
    }
}
