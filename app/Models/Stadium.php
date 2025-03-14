<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StadiumImage;

class Stadium extends Model
{
    use HasFactory;

    protected $table = 'stadiums'; // Xác định đúng tên bảng
    protected $fillable = [
        'name',
        'phone',
        'description',
        'location',
        'price_per_hour',
        'field_count',
        'encrypted_image'
        
    ];

    public function images()
    {
        return $this->hasMany(StadiumImage::class);
    }

    
}
