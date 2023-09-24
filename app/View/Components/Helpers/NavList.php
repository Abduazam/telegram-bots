<?php

namespace App\View\Components\Helpers;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\View\Component;

class NavList extends Component
{
    protected Request $request;
    /**
     * Create a new component instance.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.helpers.nav-list', [
            'request' => $this->request
        ]);
    }
}
