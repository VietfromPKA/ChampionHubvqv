<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'coach_name',
        'user_id',
        'tournament_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class); // mỗi đội bóng thuộc về một người dùng
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function gamesAsTeam1()
    {
        return $this->hasMany(Game::class, 'team1_id');
    }

    public function gamesAsTeam2()
    {
        return $this->hasMany(Game::class, 'team2_id');
    }

    public function players()
    {
        return $this->hasMany(Player::class, 'team_id');
    }

    public function matches()
    {
        return $this->hasMany(MatchSchedule::class, 'team1_id')->orWhere('team2_id', $this->id);
    }

    public function winsCount()
    {
        return MatchSchedule::query()
            ->where('status', 'completed')
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('team1_id', $this->id)
                      ->whereRaw('scoreTeam1 > scoreTeam2');
                })->orWhere(function ($q) {
                    $q->where('team2_id', $this->id)
                      ->whereRaw('scoreTeam2 > scoreTeam1');
                });
            })
            ->count();
    }
    
    public function drawsCount()
    {
        return MatchSchedule::query()
            ->where('status', 'completed')
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('team1_id', $this->id)
                      ->whereRaw('scoreTeam1 = scoreTeam2');
                })->orWhere(function ($q) {
                    $q->where('team2_id', $this->id)
                      ->whereRaw('scoreTeam1 = scoreTeam2');
                });
            })
            ->count();
    }
    
    public function lossesCount()
    {
        return MatchSchedule::query()
            ->where('status', 'completed')
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('team1_id', $this->id)
                      ->whereRaw('scoreTeam1 < scoreTeam2');
                })->orWhere(function ($q) {
                    $q->where('team2_id', $this->id)
                      ->whereRaw('scoreTeam2 < scoreTeam1');
                });
            })
            ->count();
    }
    
    public function goalDifference()
    {
        // Lấy tổng bàn thắng khi đội là team1
        $team1Goals = MatchSchedule::query()
            ->where('status', 'completed')
            ->where('team1_id', $this->id)
            ->sum('scoreTeam1');
        
        // Lấy tổng bàn thắng khi đội là team2
        $team2Goals = MatchSchedule::query()
            ->where('status', 'completed')
            ->where('team2_id', $this->id)
            ->sum('scoreTeam2');
        
        // Tổng số bàn thắng
        $totalGoalsScored = $team1Goals + $team2Goals;
        
        // Lấy tổng bàn thua khi đội là team1
        $team1Conceded = MatchSchedule::query()
            ->where('status', 'completed')
            ->where('team1_id', $this->id)
            ->sum('scoreTeam2');
        
        // Lấy tổng bàn thua khi đội là team2
        $team2Conceded = MatchSchedule::query()
            ->where('status', 'completed')
            ->where('team2_id', $this->id)
            ->sum('scoreTeam1');
        
        // Tổng số bàn thua
        $totalGoalsConceded = $team1Conceded + $team2Conceded;
        
        // Hiệu số bàn thắng - bàn thua
        return $totalGoalsScored - $totalGoalsConceded;
    }

    public function totalPoints()
    {
        // Số trận thắng
        $wins = $this->winsCount();
        
        // Số trận hòa
        $draws = $this->drawsCount();
        
        // Tính tổng điểm (Thắng = 3 điểm, Hòa = 1 điểm)
        return ($wins * 3) + ($draws * 1);
    }

}
