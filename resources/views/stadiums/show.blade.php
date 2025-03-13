@extends('layouts.app')

@section('title', 'Chi tiết sân bóng')

@section('content')
<h2>Chi tiết sân bóng</h2>
<p><strong>Tên sân:</strong> {{ $stadium->name }}</p>
<p><strong>Vị trí:</strong> {{ $stadium->location }}</p>
<p><strong>Giá thuê:</strong> {{ number_format($stadium->price_per_hour) }} VNĐ/giờ</p>
<p><strong>Số lượng sân:</strong> {{ $stadium->field_count }}</p>
<a href="{{ route('stadiums.index') }}" class="btn btn-secondary">Quay lại</a>
@endsection
