<?php

namespace App\Models\Bots\General\Bots;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bots\General\Users\BotUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Table columns
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $token
 *
 * Relations
 * @property HasMany $bot_users
 */
class Bot extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'username',
        'token',
    ];

    /**
     * Define translations belongs to text.
     *
     * @return HasMany
     */
    public function bot_users(): HasMany
    {
        return $this->hasMany(BotUser::class);
    }
}
