@extends('layouts.app')

@section('title', isset($stadium) ? 'Chỉnh sửa sân bóng' : 'Thêm sân bóng')

@section('content')
<h2>{{ isset($stadium) ? 'Chỉnh sửa sân bóng' : 'Thêm sân bóng' }}</h2>

<form action="{{ isset($stadium) ? route('stadiums.update', $stadium->id) : route('stadiums.store') }}" method="POST">
    @csrf
    @if(isset($stadium)) 
        @method('PUT') 
    @endif

    <div class="mb-3">
        <label class="form-label">Tên sân:</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $stadium->name ?? '') }}" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Vị trí:</label>
        <input type="text" name="location" class="form-control" value="{{ old('location', $stadium->location ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Giá thuê (VNĐ/giờ):</label>
        <input type="number" name="price_per_hour" class="form-control" value="{{ old('price_per_hour', $stadium->price_per_hour ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Số lượng sân:</label>
        <input type="number" name="field_count" class="form-control" value="{{ old('field_count', $stadium->field_count ?? '') }}" required>
    </div>

    <button type="submit" class="btn btn-success">{{ isset($stadium) ? 'Cập nhật' : 'Thêm mới' }}</button>
    <a href="{{ route('stadiums.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
@endsection
