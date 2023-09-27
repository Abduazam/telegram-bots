<?php

namespace App\Contracts\Enums\Bots\General;

enum FileTypeEnum : string
{
    case AUDIO = 'audio';
    case VOICE = 'voice';
    case PHOTO = 'photo';
    case VIDEO = 'video';
    case FILE = 'file';
}
