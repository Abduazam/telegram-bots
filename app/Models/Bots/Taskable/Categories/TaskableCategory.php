<?php

namespace App\Models\Bots\Taskable\Categories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bots\General\Users\BotUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Bots\Taskable\Categories\Traits\TaskableCategoryMethods;

/**
 * Table columns
 * @property int $bot_user_id
 * @property string $slug
 * @property string $title
 *
 * Relations
 * @property BelongsTo $user
 */
class TaskableCategory extends Model
{
    use HasFactory, SoftDeletes;
    use TaskableCategoryMethods;

    protected $fillable = [
        'bot_user_id',
        'slug',
        'title',
    ];

    /**
     * BotCategory model relations.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(BotUser::class);
    }
}
