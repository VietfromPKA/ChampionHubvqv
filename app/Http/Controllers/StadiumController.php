<?php

namespace App\Http\Controllers;

use App\Models\Stadium;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\StadiumImage;
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
        return view('stadiums.form', ['stadium' => null]); // Đảm bảo form.blade.php không lỗi
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
    public function edit($id)
    {
        $stadium = Stadium::findOrFail($id);
        return view('stadiums.form', compact('stadium'));
    }

    // Xử lý cập nhật sân bóng
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'price_per_hour' => 'required|numeric|min:0',
            'field_count' => 'required|integer|min:1',
        ]);

        $stadium = Stadium::findOrFail($id);
        $stadium->update($request->all());

        return redirect()->route('stadiums.index')->with('success', 'Cập nhật sân bóng thành công!');
    }

    // Xóa sân bóng
    public function destroy($id)
    {
        $stadium = Stadium::findOrFail($id);
        $stadium->delete();

        return redirect()->route('stadiums.index')->with('success', 'Xóa sân bóng thành công!');
    }

    // Hiển thị chi tiết sân bóng
    public function show($id)
    {
        $stadium = Stadium::findOrFail($id);
        return view('stadiums.show', compact('stadium'));
    }

    public function uploadImage(Request $request, $stadiumId)
    {
        $request->validate([
            'image' => 'required|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $stadium = Stadium::findOrFail($stadiumId);

        foreach ($request->file('image') as $imageFile) {
            // Tải ảnh lên Cloudinary
            $uploadedFile = Cloudinary::upload($imageFile->getRealPath());

            // Lấy URL của ảnh từ Cloudinary
            $imageUrl = $uploadedFile->getSecurePath();

            // Lưu thông tin ảnh vào bảng stadium_images
            $stadium->images()->create([
                'image_url' => $imageUrl
            ]);
        }

        return redirect()->route('stadiums.show', $stadiumId)->with('success', 'Ảnh đã được tải lên thành công!');
    }
    public function deleteImage($imageId)
    {
        // Tìm ảnh trong bảng stadium_images
        $image = StadiumImage::findOrFail($imageId);
        $stadium = $image->stadium;

        // Kiểm tra nếu ảnh có tồn tại trên Cloudinary
        if ($image->image_url) {
            // Lấy public_id từ URL và xóa ảnh trên Cloudinary
            $publicId = basename($image->image_url, '.' . pathinfo($image->image_url, PATHINFO_EXTENSION));
            Cloudinary::destroy($publicId);
        }

        // Xóa ảnh khỏi cơ sở dữ liệu
        $image->delete();

        return redirect()->route('stadiums.show', $stadium->id)->with('success', 'Ảnh đã được xóa thành công!');
    }

}
