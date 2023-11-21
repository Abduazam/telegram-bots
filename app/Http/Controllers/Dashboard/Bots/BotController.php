<?php

namespace App\Http\Controllers\Dashboard\Bots;

use Illuminate\View\View;
use App\Http\Controllers\Dashboard\DashboardController;

class BotController extends DashboardController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('dashboard.bots.index');
    }
}
