@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/qlygiaidau.css') }}" rel="stylesheet">
@endsection

@section('content')
    <h1 id="tournament-title">Quản lý Giải đấu</h1>
    <a href="{{ route('tournament.create') }}" id="create-tournament">Tạo mới giải đấu</a>

    <table id="tournament-table">
        <thead>
            <tr>
                <th>Tên giải đấu</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tournaments as $tournament)
                <tr class="tournament-row">
                    <td class="tournament-name">{{ $tournament->name }}</td>
                    <td class="tournament-start-date">{{ $tournament->start_date }}</td>
                    <td class="tournament-end-date">{{ $tournament->end_date }}</td>
                    <td class="action-buttons-cell">
                        <form action="{{ route('tournament.edit', $tournament->id) }}" method="GET">
                            <button type="submit" class="edit-button">Sửa</button>
                        </form>
                        <form action="{{ route('tournament.destroy', $tournament->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection