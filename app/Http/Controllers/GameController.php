<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\Request;

class GameController extends Controller
{
    // Hiển thị danh sách tất cả các trận đấu
    public function index()
    {
        $games = Game::with(['tournament', 'team1', 'team2'])->get();
        return view('games.index', compact('games'));
    }

    // Hiển thị form tạo trận đấu
    public function create()
    {
        $tournaments = Tournament::where('user_id', auth()->id())->get(); // Danh sách giải đấu
        $teams = Team::whereIn('tournament_id', $tournaments->pluck('id'))->get();
        return view('games.create', compact('tournaments', 'teams'));
    }

    // Lưu trận đấu mới
    public function store(Request $request)
    {
        $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'team1_id' => 'required|exists:teams,id|different:team2_id',
            'team2_id' => 'required|exists:teams,id',
            'match_date' => 'required|date',
            'location' => 'required|string|max:255',
        ]);

        Game::create($request->all());

        return redirect()->route('games.index')->with('success', 'Game created successfully!');
    }

    // Hiển thị chi tiết một trận đấu
    public function show($id)
    {
        $game = Game::with(['tournament', 'team1', 'team2'])->findOrFail($id);
        return view('games.show', compact('game'));
    }

    // Hiển thị form chỉnh sửa trận đấu
    public function edit($id)
    {
        $game = Game::with('tournament')->findOrFail($id);

        // Kiểm tra quyền sở hữu giải đấu
        if ($game->tournament->user_id !== auth()->id()) {
            return redirect()->route('games.index')->with('error', 'Bạn không có quyền chỉnh sửa trận đấu này.');
        }

        $tournaments = Tournament::all();
        $teams = Team::all();

        return view('games.edit', compact('game', 'tournaments', 'teams'));
    }


    // Cập nhật thông tin trận đấu
    public function update(Request $request, $id)
    {
        $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'team1_id' => 'required|exists:teams,id|different:team2_id',
            'team2_id' => 'required|exists:teams,id',
            'match_date' => 'required|date',
            'location' => 'required|string|max:255',
        ]);

        $game = Game::with('tournament')->findOrFail($id);

        // Kiểm tra quyền sở hữu giải đấu
        if ($game->tournament->user_id !== auth()->id()) {
            return redirect()->route('games.index')->with('error', 'Bạn không có quyền cập nhật trận đấu này.');
        }

        $game->update($request->all());

        return redirect()->route('games.index')->with('success', 'Game updated successfully!');
    }


    // Xóa một trận đấu
    public function destroy($id)
    {
        $game = Game::with('tournament')->findOrFail($id);

        // Kiểm tra quyền sở hữu giải đấu
        if ($game->tournament->user_id !== auth()->id()) {
            return redirect()->route('games.index')->with('error', 'Bạn không có quyền xóa trận đấu này.');
        }

        $game->delete();

        return redirect()->route('games.index')->with('success', 'Game deleted successfully!');
    }

}
