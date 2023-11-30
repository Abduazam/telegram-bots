<?php

namespace App\Livewire\Bots\Taskablebot\Users;

use Livewire\Component;
use Illuminate\View\View;
use App\Contracts\Traits\Dashboard\Livewire\General\SortingTrait;
use App\Contracts\Traits\Dashboard\Livewire\General\SearchingTrait;
use App\Contracts\Traits\Dashboard\Livewire\General\PaginatingTrait;
use App\Contracts\Traits\Dashboard\Livewire\Models\BotUserStatusTrait;
use App\Repository\Dashboard\Bots\Taskable\Users\TaskableUsersRepository;

class Index extends Component
{
    use SearchingTrait, PaginatingTrait, SortingTrait, BotUserStatusTrait;

    public function render(TaskableUsersRepository $taskableUsersRepository): View
    {
        return view('livewire.bots.taskablebot.users.index', [
            'users' => $taskableUsersRepository->getFiltered($this->search, $this->perPage, $this->user_status, $this->orderBy, $this->orderDirection),
        ]);
    }
}
