<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        // Lấy đội bóng của người dùng hiện tại và bao gồm cả thông tin giải đấu
        $teams = Auth::user()->teams()->with('tournament')->get(); 
        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        // Lấy tất cả giải đấu để hiển thị trong form tạo đội bóng
        $tournaments = Tournament::all();
        return view('teams.create', compact('tournaments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'coach_name' => 'nullable|string|max:255',
            'tournament_id' => 'required|exists:tournaments,id', // Kiểm tra giải đấu hợp lệ
        ]);

        // Tạo đội bóng mới
        $team = new Team();
        $team->name = $request->name;
        $team->coach_name = $request->coach_name;
        $team->user_id = Auth::id(); // Liên kết đội bóng với người dùng hiện tại
        $team->tournament_id = $request->tournament_id; // Liên kết đội bóng với giải đấu
        $team->save();

        return redirect()->route('team.index')->with('success', 'Đội bóng đã được thêm.');
    }

    public function edit($id)
    {
        // Lấy đội bóng của người dùng hiện tại và thông tin giải đấu
        $team = Auth::user()->teams()->findOrFail($id);
        $tournaments = Tournament::all();
        return view('teams.edit', compact('team', 'tournaments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'coach_name' => 'nullable|string|max:255',
            'tournament_id' => 'required|exists:tournaments,id',
        ]);

        // Cập nhật đội bóng
        $team = Auth::user()->teams()->findOrFail($id);
        $team->name = $request->name;
        $team->coach_name = $request->coach_name;
        $team->tournament_id = $request->tournament_id;
        $team->save();

        return redirect()->route('team.index')->with('success', 'Đội bóng đã được cập nhật.');
    }

    public function destroy($id)
    {
        // Xóa đội bóng của người dùng hiện tại
        $team = Auth::user()->teams()->findOrFail($id);
        $team->delete();

        return redirect()->route('team.index')->with('success', 'Đội bóng đã được xóa.');
    }
}
