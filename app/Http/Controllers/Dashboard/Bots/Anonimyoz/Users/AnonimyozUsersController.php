<?php

namespace App\Http\Controllers\Dashboard\Bots\Anonimyoz\Users;

use Illuminate\View\View;
use App\Http\Controllers\Dashboard\DashboardController;

class AnonimyozUsersController extends DashboardController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('dashboard.bots.anonimyozbot.users.index');
    }
}
