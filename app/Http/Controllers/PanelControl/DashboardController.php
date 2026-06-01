<?php

namespace App\Http\Controllers\PanelControl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('controll-panel.movie');
    }

    public function favorite()
    {
        $userId = Auth::id();
        $favorites = \App\Models\Favorite::where('user_id', $userId)->get();

        return view('controll-panel.favorite', [
            'favorites' => $favorites,
        ]);
    }
}
