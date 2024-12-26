<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiaiDau extends Model
{
    use HasFactory;

    // Nếu tên bảng không phải là "giai_daus" (theo quy tắc của Laravel), bạn cần khai báo tên bảng:
    protected $table = 'tournaments'; // Tên bảng trong database

    // Các cột có thể gán giá trị hàng loạt
    protected $fillable = ['ten', 'dia_diem', 'ngay_bat_dau', 'ngay_ket_thuc'];
}
