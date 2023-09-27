<?php

namespace App\Models\Bots\BotTexts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotText extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'locale',
        'translation',
    ];
}
