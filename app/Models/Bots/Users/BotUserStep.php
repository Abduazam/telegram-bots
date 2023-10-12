<?php

namespace App\Models\Bots\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $bot_user_id
 * @property int $step_one
 * @property int $step_two
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
     * BotUserStep model relations.
     */
    public function user(): void
    {
        $this->belongsTo(BotUser::class);
    }
}
