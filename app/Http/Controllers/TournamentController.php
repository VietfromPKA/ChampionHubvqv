<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use Illuminate\Support\Facades\Auth;

class TournamentController extends Controller
{
    // Hiển thị danh sách giải đấu của người dùng
    public function index()
    {
        $tournaments = Auth::user()->tournaments;
        return view('tournaments.index', compact('tournaments'));
    }

    // Hiển thị form tạo mới giải đấu
    public function create()
    {
        return view('tournaments.create');
    }

    // Lưu giải đấu mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Tạo mới giải đấu
        $tournament = new Tournament();
        $tournament->user_id = Auth::id(); // Liên kết giải đấu với người dùng hiện tại
        $tournament->name = $request->name;
        $tournament->start_date = $request->start_date;
        $tournament->end_date = $request->end_date;
        $tournament->save();

        return redirect()->route('tournaments.index')->with('success', 'Giải đấu đã được thêm.');
    }

    // Hiển thị form chỉnh sửa giải đấu
    public function edit($id)
    {
        $tournament = Auth::user()->tournaments()->findOrFail($id);
        return view('tournaments.edit', compact('tournament'));
    }

    // Cập nhật giải đấu
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $tournament = Auth::user()->tournaments()->findOrFail($id);
        $tournament->name = $request->name;
        $tournament->start_date = $request->start_date;
        $tournament->end_date = $request->end_date;
        $tournament->save();

        return redirect()->route('tournaments.index')->with('success', 'Giải đấu đã được cập nhật.');
    }

    // Xóa giải đấu
    public function destroy($id)
    {
        $tournament = Auth::user()->tournaments()->findOrFail($id);
        $tournament->delete();
        return redirect()->route('tournaments.index')->with('success', 'Giải đấu đã được xóa.');
    }

    public function show($id)
    {
        $tournament = Tournament::with(['teams'])->findOrFail($id);
        return view('tournaments.show', compact('tournament'));
    }

    public function tournament()
    {
        // Lấy danh sách tất cả các giải đấu
        $tournaments = Tournament::all();
        return view('public.tournaments.index', compact('tournaments'));
    }

}
