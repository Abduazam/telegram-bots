<?php

namespace App\Models\Bots\General\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Table columns
 * @property int $id
 * @property int $bot_user_id
 * @property int $step_one
 * @property int $step_two
 *
 * Relations
 * @property BelongsTo $bot_user
 */
class BotUserStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'bot_user_id',
        'step_one',
        'step_two',
    ];

    /**
     * Defines steps belongs to bot user.
     */
    public function bot_user(): BelongsTo
    {
        return $this->belongsTo(BotUser::class);
    }
}
