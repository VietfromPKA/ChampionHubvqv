<?php

namespace App\Http\Controllers;

use App\Models\Stadium;
use Illuminate\Http\Request;

class StadiumController extends Controller
{
    // Hiển thị danh sách sân bóng
    public function index()
    {
        $stadiums = Stadium::all();
        return view('stadiums.index', compact('stadiums'));
    }

    // Hiển thị form thêm sân bóng
    public function create()
    {
        return view('stadiums.form'); // Dùng chung form.blade.php
    }

    // Xử lý thêm mới sân bóng
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'price_per_hour' => 'required|numeric|min:0',
            'field_count' => 'required|integer|min:1',
        ]);

        Stadium::create($request->all());
        return redirect()->route('stadiums.index')->with('success', 'Thêm sân bóng thành công!');
    }

    // Hiển thị form chỉnh sửa sân bóng
    public function edit(Stadium $stadium)
    {
        return view('stadiums.form', compact('stadium'));
    }

    // Xử lý cập nhật sân bóng
    public function update(Request $request, Stadium $stadium)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'price_per_hour' => 'required|numeric|min:0',
            'field_count' => 'required|integer|min:1',
        ]);

        $stadium->update($request->all());
        return redirect()->route('stadiums.index')->with('success', 'Cập nhật sân bóng thành công!');
    }

    // Xóa sân bóng
    public function destroy(Stadium $stadium)
    {
        $stadium->delete();
        return redirect()->route('stadiums.index')->with('success', 'Xóa sân bóng thành công!');
    }

    public function show(Stadium $stadium)
    {
        return view('stadiums.show', compact('stadium'));
    }

}