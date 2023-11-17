<?php

namespace App\Models\Bots\Taskable\Categories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bots\General\Users\BotUser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Table columns
 * @property int $bot_user_id
 * @property int $taskable_category_id
 *
 * Relations
 * @property BelongsTo $user
 * @property BelongsTo $category
 */
class TaskableInactiveCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'bot_user_id',
        'taskable_category_id',
    ];

    /**
     * Belongs to Bot user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(BotUser::class);
    }

    /**
     * Belongs to Taskable category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(TaskableCategory::class);
    }
}
