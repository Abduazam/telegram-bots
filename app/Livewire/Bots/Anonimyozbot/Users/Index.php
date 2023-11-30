<?php

namespace App\Livewire\Bots\Anonimyozbot\Users;

use Livewire\Component;
use Illuminate\View\View;
use App\Contracts\Traits\Dashboard\Livewire\General\SortingTrait;
use App\Contracts\Traits\Dashboard\Livewire\General\SearchingTrait;
use App\Contracts\Traits\Dashboard\Livewire\General\PaginatingTrait;
use App\Repository\Dashboard\Bots\Anonimyoz\Users\AnonimyozUsersRepository;

class Index extends Component
{
    use SearchingTrait, PaginatingTrait, SortingTrait;

    public function render(AnonimyozUsersRepository $anonimyozUsersRepository): View
    {
        return view('livewire.bots.anonimyoz.users.index', [
            'users' => $anonimyozUsersRepository->getFiltered($this->search, $this->perPage, $this->orderBy, $this->orderDirection),
        ]);
    }
}
