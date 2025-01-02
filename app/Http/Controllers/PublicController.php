<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Team;

class PublicController extends Controller
{
    public function tournament()
    {
        // Lấy danh sách tất cả các giải đấu
        $tournaments = Tournament::all();

        return view('public.tournaments.index', compact('tournaments'));
    }
    public function team(){
        $teams = Team::all();
        return view('public.teams.index', compact('teams'));
    }
}
