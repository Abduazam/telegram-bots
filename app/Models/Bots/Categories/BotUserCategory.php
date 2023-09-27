<?php

namespace App\Models\Bots\Categories;

use App\Models\Bots\Users\BotUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $bot_user_id
 * @property string $translation
 */
class BotUserCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bot_user_id',
        'translation',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(BotUser::class);
    }

    public function getTranslation(): bool|string
    {
        return base64_decode($this->translation);
    }
}
