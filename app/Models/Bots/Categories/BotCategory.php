<?php

namespace App\Models\Bots\Categories;

use App\Models\Bots\Users\BotUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $bot_user_id
 * @property string $slug
 * @property string $title
 */
class BotCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bot_user_id',
        'slug',
        'title',
    ];

    /**
     * BotCategory model attribute getters.
     */
    public function getTitle(): bool|string
    {
        return base64_decode($this->title);
    }

    /**
     * BotCategory model relations.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(BotUser::class);
    }
}
