<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index($teamId)
{
    // Lấy đội bóng dựa vào ID
    $team = Team::with('players')->findOrFail($teamId);
    $players = $team->players;

    // Truyền dữ liệu tới view
    return view('players.index', compact('team', 'players'));
}


    public function create($teamId)
    {
        $team = Team::findOrFail($teamId);
        return view('players.create', compact('team'));
    }

    public function store(Request $request, $teamId)
    {
        $team = Team::findOrFail($teamId);

        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer',
            'position' => 'nullable|string|max:255',
            'jersey_number' => 'required|integer|unique:players,jersey_number',
            'email' => 'required|email|unique:players,email',
        ]);

        $team->players()->create($request->all());

        return redirect()->route('players.index', $teamId)->with('success', 'Cầu thủ đã được thêm!');
    }

}
