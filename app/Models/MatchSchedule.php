<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id', 
        'team1_id', 
        'team2_id', 
        'stadium_id', 
        'field_number', 
        'schedule_type', 
        'match_date', 
        'scoreTeam1', 
        'scoreTeam2', 
        'status',
        'location'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function team1()
    {
        return $this->belongsTo(Team::class, 'team1_id');
    }

    public function team2()
    {
        return $this->belongsTo(Team::class, 'team2_id');
    }

    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }
}
