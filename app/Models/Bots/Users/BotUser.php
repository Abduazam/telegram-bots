<?php

namespace App\Models\Bots\Users;

use App\Models\Bots\Categories\BotUserCategory;
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
 * @property HasOne $steps
 */
class BotUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'chat_id',
        'first_name',
        'username',
        'phone_number',
        'is_view',
        'active',
    ];

    public function getFirstName(): string
    {
        return base64_decode($this->first_name);
    }

    public function getUsername(): string
    {
        return base64_decode($this->username);
    }

    public function isActive(): bool
    {
        return $this->active === 1;
    }

    public function isBlocked(): bool
    {
        return $this->active === 2;
    }

    public function steps(): HasOne
    {
        return $this->hasOne(BotUserStep::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(BotUserCategory::class, 'bot_user_id');
    }

    public function updateSteps(int $step_one, int $step_two): void
    {
        $this->steps->update([
            'step_one' => $step_one,
            'step_two' => $step_two,
        ]);
    }
}
