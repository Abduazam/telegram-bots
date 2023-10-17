<?php

namespace App\Models\Bots\Users;

use App\Contracts\Traits\Bots\Models\StatusChecker;
use App\Models\Bots\Categories\BotCategory;
use App\Models\Bots\Tasks\BotUserTask;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $chat_id
 * @property string $first_name
 * @property string $username
 * @property string $phone_number
 * @property boolean $is_view
 * @property int $active
 */
class BotUser extends Model
{
    use HasFactory, SoftDeletes;
    use StatusChecker;

    protected $fillable = [
        'chat_id',
        'first_name',
        'username',
        'phone_number',
        'is_view',
        'active',
    ];

    /**
     * BotUser model attribute getters.
     */
    public function getFirstName(): string
    {
        return base64_decode($this->first_name);
    }

    public function getUsername(): string
    {
        return base64_decode($this->username);
    }

    /**
     * BotUser model relations.
     */
    public function steps(): HasOne
    {
        return $this->hasOne(BotUserStep::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(BotCategory::class);
    }

    public function log(): HasOne
    {
        return $this->hasOne(BotUserLog::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(BotUserTask::class)->withTrashed();
    }

    public function updateSteps(int $step_one, int $step_two): void
    {
        $this->steps->update([
            'step_one' => $step_one,
            'step_two' => $step_two,
        ]);
    }
}
