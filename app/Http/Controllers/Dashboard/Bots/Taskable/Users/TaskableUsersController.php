<?php

namespace App\Http\Controllers\Dashboard\Bots\Taskable\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskableUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('dashboard.bots.taskablebot.users.index');
    }
}
