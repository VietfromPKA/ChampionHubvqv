<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'name',
        'age',
        'position',
        'team_id',
        'jersey_number', // Thêm số áo
        'email',         // Thêm email
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    
}
