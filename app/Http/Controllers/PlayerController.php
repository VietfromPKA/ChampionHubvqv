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
        // Debug dữ liệu nhận được
        \Log::info('Dữ liệu nhận được:', $request->all());
    
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'age' => 'nullable|integer',
                'position' => 'nullable|string|max:255',
                'jersey_number' => 'required|integer|unique:players,jersey_number,NULL,id,team_id,' . $teamId,
                'email' => 'required|email|unique:players,email,NULL,id,team_id,' . $teamId,
            ]);
            ;
    
            \Log::info('Dữ liệu hợp lệ:', $validated);
    
            $player = Player::create([
                'name' => $request->name,
                'age' => $request->age,
                'position' => $request->position,
                'jersey_number' => $request->jersey_number,
                'email' => $request->email,
                'team_id' => $teamId,
            ]);
    
            \Log::info('Cầu thủ đã tạo:', $player->toArray());
    
            return redirect()->route('players.index', $teamId)->with('success', 'Cầu thủ đã được thêm!');
        } catch (\Exception $e) {
            \Log::error('Lỗi khi thêm cầu thủ:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
}
