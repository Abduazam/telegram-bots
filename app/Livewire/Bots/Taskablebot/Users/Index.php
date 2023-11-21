<?php

namespace App\Livewire\Bots\Taskablebot\Users;

use App\Models\Bots\General\Users\BotUser;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        return view('livewire.bots.taskablebot.users.index', [
            'users' => BotUser::where('bot_id', 1)->get(),
        ]);
    }
}
