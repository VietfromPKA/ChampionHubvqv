<?php

namespace App\Http\Controllers;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use App\Models\Tournament;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $tournaments = Tournament::where('user_id', $user->id)->get();
        $teams = Team::where('user_id', $user->id)->get();
        return view('user.index', compact('user', 'tournaments', 'teams'));
    }
}
