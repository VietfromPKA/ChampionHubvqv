@extends('layouts.app')
<link href="{{ asset('css/stadium.css') }}" rel="stylesheet">
@section('title', 'Danh sách sân bóng')

@section('content')
    <div class="container main-container">
        <h2 class="page-title">Danh sách sân bóng thuộc hệ thống ChampionHub</h2>

        <div class="table-wrapper">
            <table class="table table-bordered data-table">
                <thead class="table-head">
                    <tr>
                        <th>STT</th>
                        <th>Tên sân</th>
                        <th>Vị trí</th>
                        <th>Giá thuê (VNĐ/giờ)</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stadiums as $stadium)
                        <tr class="table-row">
                            <td>{{ $loop->iteration }}</td>
                            <td class="name-cell">{{ $stadium->name }}</td>
                            <td class="location-cell">{{ $stadium->location }}</td>
                            <td class="price-cell">{{ number_format($stadium->price_per_hour) }}</td>
                            <td class="actions-cell">
                                <a href="{{ route('stadiums.show', $stadium->id) }}"
                                    class="btn btn-info btn-sm view-btn">Xem</a>

                                @if(auth()->check() && auth()->user()->role === 'admin')
                                    <a href="{{ route('stadiums.edit', $stadium->id) }}"
                                        class="btn btn-warning btn-sm edit-btn">Sửa</a>
                                    <form action="{{ route('stadiums.destroy', $stadium->id) }}" method="POST"
                                        class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm delete-btn"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between mb-3 action-bar">
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('stadiums.create') }}" class="btn btn-primary add-btn">Thêm sân bóng</a>
            @endif
        </div>
    </div>
@endsection