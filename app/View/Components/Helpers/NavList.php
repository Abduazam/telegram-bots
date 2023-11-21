<?php

namespace App\View\Components\Helpers;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Repository\Bots\Models\General\BotRepository;

class NavList extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(protected BotRepository $botRepository) { }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.helpers.nav-list', [
            'bots' => $this->botRepository->getAll(),
        ]);
    }
}
