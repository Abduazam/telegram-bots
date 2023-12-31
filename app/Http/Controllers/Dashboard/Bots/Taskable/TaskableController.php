<?php

namespace App\Http\Controllers\Dashboard\Bots\Taskable;

use Illuminate\View\View;
use App\Http\Controllers\Dashboard\DashboardController;

class TaskableController extends DashboardController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('dashboard.bots.taskablebot.index');
    }
}
