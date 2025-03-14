<?php

namespace App\Http\Controllers;

use App\Models\MatchSchedule;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Stadium;
use Illuminate\Http\Request;

class MatchScheduleController extends Controller
{
    // Hiển thị danh sách lịch thi đấu
    public function index()
    {
        $matches = MatchSchedule::with(['tournament', 'team1', 'team2', 'stadium'])->get();
        return view('matches.index', compact('matches'));
    }

    // Hiển thị form tạo lịch thi đấu
    public function create(Request $request)
    {
        // Kiểm tra nếu có tournamentId thì lấy thông tin giải đấu
        $tournament = Tournament::with('teams')->findOrFail($request->tournamentId);
        $teams = $tournament->teams; // Chỉ lấy đội bóng thuộc giải đấu này
        $stadiums = Stadium::all(); // Lấy danh sách sân đấu

        return view('matches.create', compact('tournament', 'teams', 'stadiums'));
    }


    // Lưu lịch thi đấu mới
    public function store(Request $request)
    {
        $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'team1_id' => 'required|exists:teams,id',
            'team2_id' => 'required|exists:teams,id|different:team1_id',
            'stadium_id' => 'required|exists:stadiums,id',
            'field_number' => 'required|integer|min:1',
            'match_date' => 'required|date',
            'location' => 'required|string|max:255',
        ]);

        MatchSchedule::create([
            'tournament_id' => $request->tournament_id,
            'team1_id' => $request->team1_id,
            'team2_id' => $request->team2_id,
            'stadium_id' => $request->stadium_id,
            'field_number' => $request->field_number,
            'match_date' => $request->match_date,
            'location' => $request->location,
        ]);

        return redirect()->route('tournament.show', ['id' => $request->tournament_id])
            ->with('success', 'Lịch thi đấu đã được tạo thành công!');

    }


    // Hiển thị chi tiết một lịch thi đấu
    public function show($id)
    {
        $match = MatchSchedule::with(['tournament', 'team1', 'team2', 'stadium'])->findOrFail($id);
        return view('matches.show', compact('match'));
    }

    // Hiển thị form chỉnh sửa lịch thi đấu
    public function edit($id)
    {
        $match = MatchSchedule::findOrFail($id);
        $tournament = $match->tournament;
        $teams = $tournament->teams; // Chỉ lấy đội bóng thuộc giải đấu này
        $stadiums = Stadium::all(); // Lấy danh sách sân đấu

        return view('matches.edit', compact('match', 'tournament', 'teams', 'stadiums'));
    }


    // Cập nhật thông tin lịch thi đấu
    public function update(Request $request, $id)
    {
        $request->validate([
            'team1_id' => 'required|exists:teams,id|different:team2_id',
            'team2_id' => 'required|exists:teams,id',
            'stadium_id' => 'required|exists:stadiums,id',
            'field_number' => 'required|integer|min:1',
            'match_date' => 'required|date',
            'location' => 'required|string|max:255',
        ]);

        $match = MatchSchedule::findOrFail($id);

        // Chỉ cập nhật các trường cần thiết
        $match->update([
            'team1_id' => $request->team1_id,
            'team2_id' => $request->team2_id,
            'stadium_id' => $request->stadium_id,
            'field_number' => $request->field_number,
            'match_date' => $request->match_date,
            'location' => $request->location,
        ]);

        return redirect()->route('matches.index')->with('success', 'Lịch thi đấu đã được cập nhật!');
    }


    // Xóa một lịch thi đấu
    public function destroy($id)
    {
        $match = MatchSchedule::findOrFail($id);
        $match->delete();

        return redirect()->route('matches.index')->with('success', 'Lịch thi đấu đã được xóa!');
    }
}
