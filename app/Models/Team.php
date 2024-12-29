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



}
