<?php

namespace App\Models\Bots\Anonimyoz\Chat;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bots\General\Users\BotUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnonimyozChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'sender_username',
        'receiver_id',
    ];

    public function sender(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(BotUser::class, 'sender_id');
    }

    public function receiver(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
            return $this->belongsTo(BotUser::class, 'receiver_id');
    }
}
