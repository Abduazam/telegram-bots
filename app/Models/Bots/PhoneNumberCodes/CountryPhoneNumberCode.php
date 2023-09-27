<?php

namespace App\Models\Bots\PhoneNumberCodes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CountryPhoneNumberCode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'slug',
        'code',
        'name',
        'thumbnail',
    ];
}
