<?php

namespace App\Http\Controllers;

use App\Models\Stadium;
use App\Models\StadiumImage;
use Illuminate\Http\Request;

class StadiumImageController extends Controller
{
    // Phương thức thêm hình ảnh
    public function store(Request $request, $stadiumId)
    {
        $request->validate([
            'image_url' => 'required|url', // Kiểm tra URL hình ảnh hợp lệ
        ]);

        // Tìm sân bóng theo ID
        $stadium = Stadium::findOrFail($stadiumId);

        // Thêm hình ảnh vào sân bóng
        $stadium->images()->create([
            'image_url' => $request->image_url,
        ]);

        return back()->with('success', 'Image added successfully.');
    }

    // Phương thức hiển thị hình ảnh của sân bóng
    public function show($stadiumId)
    {
        $stadium = Stadium::with('images')->findOrFail($stadiumId);
        return view('stadiums.show', compact('stadium'));
    }
}
