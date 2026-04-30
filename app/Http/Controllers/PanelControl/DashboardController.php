<?php

namespace App\Http\Controllers\PanelControl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('controll-panel.movie');
    }
}
