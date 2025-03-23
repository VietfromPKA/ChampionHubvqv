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
            'match_time' => 'required|string',
            'location' => 'required|string|max:255',
        ]);

        // Kết hợp ngày và giờ thành datetime
        $startTime = explode(' - ', $request->match_time)[0]; // Lấy thời gian bắt đầu (ví dụ: "06:00")
        $matchDateTime = $request->match_date . ' ' . $startTime; // Kết hợp ngày và giờ

        MatchSchedule::create([
            'tournament_id' => $request->tournament_id,
            'team1_id' => $request->team1_id,
            'team2_id' => $request->team2_id,
            'stadium_id' => $request->stadium_id,
            'field_number' => $request->field_number,
            'match_date' => $matchDateTime, // Lưu giá trị datetime
            'location' => $request->location,
        ]);

        return redirect()->route('tournaments.show', ['tournament' => $request->tournament_id])->with('success', 'Lịch thi đấu đã được tạo thành công!');
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
            'match_time' => 'required|string',
            'location' => 'required|string|max:255',
        ]);
    
        // Kết hợp ngày và giờ thành datetime
        $startTime = explode(' - ', $request->match_time)[0]; // Lấy thời gian bắt đầu (ví dụ: "06:00")
        $matchDateTime = $request->match_date . ' ' . $startTime; // Kết hợp ngày và giờ
    
        $match = MatchSchedule::findOrFail($id);
    
        // Chỉ cập nhật các trường cần thiết
        $match->update([
            'team1_id' => $request->team1_id,
            'team2_id' => $request->team2_id,
            'stadium_id' => $request->stadium_id,
            'field_number' => $request->field_number,
            'match_date' => $matchDateTime, // Lưu giá trị datetime
            'location' => $request->location,
        ]);
    
        // Chuyển hướng về trang chi tiết giải đấu
        return redirect()->route('tournaments.show', ['tournament' => $match->tournament_id])->with('success', 'Lịch thi đấu đã được cập nhật!');
    }


    // Xóa một lịch thi đấu
    public function destroy($id)
    {
        $match = MatchSchedule::findOrFail($id);
        $tournamentId = $match->tournament_id; // Lấy tournament_id trước khi xóa
        $match->delete();

        // Chuyển hướng về trang chi tiết giải đấu
        return redirect()->route('tournaments.show', ['tournament' => $tournamentId])->with('success', 'Lịch thi đấu đã được xóa!');
    }

    // Cập nhật tỉ số trận đấu
    public function updateScore(Request $request)
    {
        $request->validate([
            'scoreTeam1' => 'required|integer|min:0',
            'scoreTeam2' => 'required|integer|min:0',
        ]);
        $match = MatchSchedule::findOrFail($request->match_id);
        $match->update([
            'scoreTeam1' => $request->scoreTeam1,
            'scoreTeam2' => $request->scoreTeam2,
            'status' => 'completed',
        ]);

        return redirect()->route('tournaments.show', ['tournament' => $request->tournament_id])->with('success', 'Tỉ số trận đấu đã được cập nhật!');
    }
}
