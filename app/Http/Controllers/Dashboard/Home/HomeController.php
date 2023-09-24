<?php

namespace App\Http\Controllers\Dashboard\Home;

use Illuminate\View\View;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): View
    {
        return view('dashboard.home.index');
    }
}
