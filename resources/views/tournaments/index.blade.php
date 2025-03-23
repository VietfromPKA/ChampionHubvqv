@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/qlygiaidau.css') }}" rel="stylesheet">
@endsection

@section('content')
    <h1 id="tournament-title">Quản lý Giải đấu</h1>
    <table id="tournament-table">
        <thead>
            <tr class="table-header">
                <th>Tên giải đấu</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Chỉnh sửa</th>
                <th>Xóa giải đấu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tournaments as $tournament)
                <tr class="tournament-row">
                    <!-- Thêm link vào tên giải đấu -->
                    <td class="tournament-name"><a href="{{ route('tournaments.show', $tournament->id) }}"
                            class="tournament-link">{{ $tournament->name }}</a></td>
                    <td class="tournament-start-date">{{ $tournament->start_date }}</td>
                    <td class="tournament-end-date">{{ $tournament->end_date }}</td>
                    <td class="action-buttons-cell"><a href="{{ route('tournaments.edit', $tournament->id) }}"><button
                                type="submit" class="edit-button">Sửa</button></a></td>
                    <td class="action-buttons-cell">
                        <form action="{{ route('tournaments.destroy', $tournament->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('tournaments.create') }}" id="create-tournament">Tạo mới giải đấu</a>

@endsection