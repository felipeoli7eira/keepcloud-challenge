<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Letter;
use Illuminate\Http\Request;
use Throwable;

class Dashboard extends Controller
{
    public function index()
    {
        return view('pages.dashboard.dashboard');
    }
}
