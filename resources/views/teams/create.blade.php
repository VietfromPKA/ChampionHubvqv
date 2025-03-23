@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/qlydoibong.css') }}" rel="stylesheet">
@endsection

@section('content')
    <h1 class="page-title">Thêm đội bóng</h1>

    <form action="{{ route('teams.store') }}" method="POST" class="team-form">
        @csrf

        <div class="form-group">
            <label for="name">Tên đội bóng</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="coach_name">Tên huấn luyện viên</label>
            <input type="text" name="coach_name" id="coach_name" class="form-control">
        </div>

        <div class="form-group">
            <label for="tournament_id">Chọn giải đấu</label>
            <select name="tournament_id" id="tournament_id" class="form-control" required>
                @foreach($tournaments as $tournament)
                    <option value="{{ $tournament->id }}">{{ $tournament->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Lưu đội bóng</button>
    </form>
@endsection
