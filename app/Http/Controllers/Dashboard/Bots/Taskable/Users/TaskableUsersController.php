<?php

namespace App\Http\Controllers\Dashboard\Bots\Taskable\Users;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskableUsersController extends DashboardController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('dashboard.bots.taskablebot.users.index');
    }
}
