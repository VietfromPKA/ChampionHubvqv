@extends('layouts.app')

@section('title', 'Danh sách sân bóng')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Danh sách sân bóng</h2>
    @if (Auth::check() && Auth::user()->role === 'admin')
        <a href="{{ route('stadiums.create') }}" class="btn btn-primary">Thêm sân bóng</a>
    @endif
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Tên sân</th>
            <th>Vị trí</th>
            <th>Giá thuê (VNĐ/giờ)</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($stadiums as $stadium)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $stadium->name }}</td>
            <td>{{ $stadium->location }}</td>
            <td>{{ number_format($stadium->price_per_hour) }}</td>
            <td>
                <a href="{{ route('stadiums.show', $stadium->id) }}" class="btn btn-info btn-sm">Xem</a>
                
                @if (Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('stadiums.edit', $stadium->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('stadiums.destroy', $stadium->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
