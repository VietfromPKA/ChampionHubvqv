<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StadiumImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'stadium_id',  // nếu bạn muốn cho phép tạo mới stadium_id qua mass assignment
        'image_url',    // thêm image_url vào đây
    ];


    // Khai báo mối quan hệ nhiều-một với Stadium
    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }
}
