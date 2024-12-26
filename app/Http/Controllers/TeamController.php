<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // Hiển thị danh sách đội bóng
    public function index()
    {
        $teams = Team::all(); // Lấy tất cả đội bóng từ cơ sở dữ liệu
        return view('teams.index', compact('teams'));
    }

    // Hiển thị form thêm đội bóng
    public function create()
    {
        $tournaments = Tournament::all(); // Lấy danh sách giải đấu
        return view('teams.create', compact('tournaments'));
    }

    // Lưu đội bóng mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'coach_name' => 'nullable|string|max:255',
            'tournament_id' => 'required|exists:tournaments,id',
        ]);

        Team::create($request->all());

        return redirect()->route('team.index')->with('success', 'Đội bóng đã được thêm thành công!');
    }

    // Hiển thị form sửa đội bóng
    public function edit($id)
    {
        $team = Team::findOrFail($id);  // Tìm đội bóng theo id
        $tournaments = Tournament::all();  // Lấy danh sách giải đấu

        return view('teams.edit', compact('team', 'tournaments'));
    }


    // Cập nhật đội bóng
    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'coach_name' => 'nullable|string|max:255',
            'tournament_id' => 'required|exists:tournaments,id',
        ]);

        $team->update($request->all());

        return redirect()->route('team.index')->with('success', 'Đội bóng đã được cập nhật thành công!');
    }

    public function destroy($id)
{
    // Tìm đội bóng theo ID, nếu không tìm thấy thì trả về lỗi 404
    $team = Team::findOrFail($id);

    // Xóa đội bóng
    $team->delete();

    // Chuyển hướng lại danh sách đội bóng với thông báo thành công
    return redirect()->route('team.index')->with('success', 'Đội bóng đã được xóa thành công!');
}

}
