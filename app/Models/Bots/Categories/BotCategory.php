<?php

namespace App\Models\Bots\Categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $slug
 */
class BotCategory extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'slug',
    ];

    public function translation(): HasOne
    {
        return $this->hasOne(BotCategoryTranslation::class)->where('locale', 'cy');
    }
}
