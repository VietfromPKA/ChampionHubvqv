<?php 

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::all(); // Lấy tất cả giải đấu
        return view('tournaments.index', compact('tournaments'));
    }

    public function create()
    {
        return view('tournaments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        Tournament::create($request->all());
        return redirect()->route('tournament.index');
    }

    public function edit($id)
    {
        $tournament = Tournament::findOrFail($id);
        return view('tournaments.edit', compact('tournament'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $tournament = Tournament::findOrFail($id);
        $tournament->update($request->all());
        return redirect()->route('tournament.index');
    }

    public function destroy($id)
    {
        $tournament = Tournament::findOrFail($id);
        $tournament->delete();
        return redirect()->route('tournament.index');
    }

    public function show($id)
    {
        // Lấy thông tin giải đấu cùng các đội bóng liên quan
        $tournament = Tournament::with('teams')->findOrFail($id);

        // Trả về view với thông tin
        return view('tournaments.show', compact('tournament'));
    }
}
