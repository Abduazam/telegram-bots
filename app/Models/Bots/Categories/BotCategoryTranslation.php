<?php

namespace App\Models\Bots\Categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $bot_category_id
 * @property string $locale
 * @property string $translation
 */
class BotCategoryTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'bot_category_id',
        'locale',
        'translation',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(BotCategory::class);
    }

    public function getTranslation(): bool|string
    {
        return base64_decode($this->translation);
    }
}
