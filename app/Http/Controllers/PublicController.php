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

    public function showTournament($id)
    {
        // Tìm giải đấu theo ID, nếu không có sẽ trả về lỗi 404
        $tournament = Tournament::findOrFail($id);

        // Trả về view hiển thị chi tiết giải đấu
        return view('public.tournaments.show', compact('tournament'));}
}
