<?php

namespace App\Models\Bots\General\Users;

use App\Models\Bots\Anonimyoz\Chat\AnonimyozChat;
use App\Models\Bots\General\Bots\Bot;
use App\Models\Bots\Taskable\Logs\TaskableLog;
use App\Models\Bots\Taskable\Tasks\TaskableTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Contracts\Traits\Bots\Models\StatusChecker;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Bots\General\Users\Traits\BotUserMethods;

/**
 * Table columns
 * @property int $id
 * @property int $bot_id
 * @property int $chat_id
 * @property string $first_name
 * @property string $username
 * @property string $phone_number
 * @property boolean $is_view
 * @property int $active
 *
 * Relations
 * @property BelongsTo $bot
 * @property HasOne $steps
 * @property HasMany $tasks
 * @property TaskableLog $taskable_log
 * @property AnonimyozChat $chat
 */
class BotUser extends Model
{
    use HasFactory, SoftDeletes;
    use StatusChecker, BotUserMethods;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string, bool>
     */
    protected $fillable = [
        'bot_id',
        'chat_id',
        'first_name',
        'username',
        'phone_number',
        'is_view',
        'active',
    ];

    /**
     * Defines bot user belongs to bot.
     *
     * @return BelongsTo
     */
    public function bot(): BelongsTo
    {
        return $this->belongsTo(Bot::class);
    }

    /**
     * Defines bot user has one steps.
     *
     * @return HasOne
     */
    public function steps(): HasOne
    {
        return $this->hasOne(BotUserStep::class);
    }

    /**
     * Defines bot user has log in Taskable bot
     *
     * @returns HasOne
     */
    public function taskable_log(): HasOne
    {
        return $this->hasOne(TaskableLog::class);
    }

    /**
     * Defines bot user has tasks in Taskable bot
     *
     * @returns HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(TaskableTask::class)->withTrashed();
    }

    public function chat(): HasOne
    {
        return $this->hasOne(AnonimyozChat::class, 'sender_id');
    }
}
