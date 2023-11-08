<?php

namespace App\Models\Bots\General\AvailableCountries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Table columns
 * @property int $id
 * @property string slug
 * @property int $code
 * @property string $name
 * @property string $thumbnail
 *
 * Relations
 */
class AvailableCountry extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'code',
        'name',
        'thumbnail',
    ];
}
