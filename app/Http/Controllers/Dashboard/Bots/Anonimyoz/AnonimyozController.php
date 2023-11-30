<?php

namespace App\Http\Controllers\Dashboard\Bots\Anonimyoz;

use Illuminate\View\View;
use App\Http\Controllers\Dashboard\DashboardController;

class AnonimyozController extends DashboardController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('dashboard.bots.anonimyozbot.index');
    }
}
