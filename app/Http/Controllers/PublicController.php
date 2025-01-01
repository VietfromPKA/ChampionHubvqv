<?php

namespace App\Http\Controllers;

use App\Models\Tournament;

class PublicController extends Controller
{
    public function index()
    {
        // Lấy danh sách tất cả các giải đấu
        $tournaments = Tournament::all();

        return view('public.tournaments.index', compact('tournaments'));
    }
}
