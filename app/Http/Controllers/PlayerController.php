<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PlayersImport;

class PlayerController extends Controller
{
    // public function index($teamId)
    // {
    //     // Lấy đội bóng dựa vào ID
    //     $team = Team::with('players')->findOrFail($teamId);
    //     $players = $team->players;

    //     // Truyền dữ liệu tới view
    //     return view('player.index', compact('team', 'players'));
    // }

    public function index(Request $request)
    {
        $teamId = $request->query('team_id'); // Lấy team_id từ URL
        dd($teamId); // Kiểm tra giá trị
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

    public function edit($teamId, $playerId)
    {
        // Lấy thông tin đội và cầu thủ
        $team = Team::findOrFail($teamId);
        $player = Player::findOrFail($playerId);

        // Truyền dữ liệu tới view
        return view('players.create', compact('team', 'player'));
    }

    public function update(Request $request, $teamId, $playerId)
    {
        // Debug dữ liệu nhận được
        \Log::info('Dữ liệu nhận được khi cập nhật:', $request->all());

        try {
            // Validate dữ liệu
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'age' => 'nullable|integer',
                'position' => 'nullable|string|max:255',
                'jersey_number' => 'required|integer|unique:players,jersey_number,' . $playerId . ',id,team_id,' . $teamId,
                'email' => 'required|email|unique:players,email,' . $playerId . ',id,team_id,' . $teamId,
            ]);

            \Log::info('Dữ liệu hợp lệ khi cập nhật:', $validated);

            // Tìm cầu thủ cần cập nhật
            $player = Player::findOrFail($playerId);

            // Cập nhật thông tin cầu thủ
            $player->update([
                'name' => $request->name,
                'age' => $request->age,
                'position' => $request->position,
                'jersey_number' => $request->jersey_number,
                'email' => $request->email,
            ]);

            \Log::info('Cầu thủ đã cập nhật:', $player->toArray());

            return redirect()->route('players.index', $teamId)->with('success', 'Cầu thủ đã được cập nhật!');
        } catch (\Exception $e) {
            \Log::error('Lỗi khi cập nhật cầu thủ:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($teamId, $playerId)
    {
        try {
            // Tìm cầu thủ cần xóa
            $player = Player::findOrFail($playerId);

            // Xóa cầu thủ
            $player->delete();

            // Chuyển hướng và thông báo thành công
            return redirect()->route('players.index', $teamId)->with('success', 'Cầu thủ đã được xóa thành công!');
        } catch (\Exception $e) {
            // Ghi log lỗi
            \Log::error('Lỗi khi xóa cầu thủ:', ['error' => $e->getMessage()]);

            // Chuyển hướng và thông báo lỗi
            return back()->withErrors(['error' => 'Đã xảy ra lỗi khi xóa cầu thủ.']);
        }
    }

    // Hiển thị form import
    public function showImportForm($teamId)
    {
        $team = Team::findOrFail($teamId);
        return view('players.import', compact('team'));
    }

    // Xử lý import từ file Excel
    public function importPlayers(Request $request, $teamId)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new PlayersImport($teamId), $request->file('file'));

        return redirect()->route('players.index', $teamId)->with('success', 'Nhập cầu thủ thành công!');
    }
}
