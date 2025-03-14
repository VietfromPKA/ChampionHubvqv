@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Danh sách lịch thi đấu</h2>
    <a href="{{ route('matches.create') }}" class="btn btn-primary mb-3">Tạo lịch thi đấu</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Giải đấu</th>
                <th>Đội 1</th>
                <th>Đội 2</th>
                <th>Sân đấu</th>
                <th>Số sân</th>
                <th>Ngày giờ</th>
                <th>Địa điểm</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($matches as $match)
            <tr>
                <td>{{ $match->id }}</td>
                <td>{{ $match->tournament->name ?? 'Trận cá nhân' }}</td>
                <td>{{ $match->team1->name }}</td>
                <td>{{ $match->team2->name }}</td>
                <td>{{ $match->stadium->name }}</td>
                <td>{{ $match->field_number }}</td>
                <td>{{ $match->match_date }}</td>
                <td>{{ $match->location }}</td>
                <td>
                    <a href="{{ route('matches.show', $match->id) }}" class="btn btn-info btn-sm">Xem</a>
                    <a href="{{ route('matches.edit', $match->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('matches.destroy', $match->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa lịch thi đấu này?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
