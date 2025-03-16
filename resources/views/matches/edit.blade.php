@extends('layouts.app')
@section('styles')
    <link href="{{ asset('css/matches.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <h1>Chỉnh Sửa Lịch Thi Đấu - {{ $tournament->name }}</h1>

        <form action="{{ route('matches.update', $match->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Phương thức PUT cho việc cập nhật dữ liệu -->

            <input type="hidden" name="tournament_id" value="{{ $tournament->id }}">

            <div class="form-group">
                <label for="team1_id">Chọn Đội 1</label>
                <select name="team1_id" id="team1_id" class="form-control" required>
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}" {{ $team->id == $match->team1_id ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="team2_id">Chọn Đội 2</label>
                <select name="team2_id" id="team2_id" class="form-control" required>
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}" {{ $team->id == $match->team2_id ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="stadium_id">Chọn Sân Đấu</label>
                <select name="stadium_id" id="stadium_id" class="form-control" required>
                    @foreach ($stadiums as $stadium)
                        <option value="{{ $stadium->id }}" {{ $stadium->id == $match->stadium_id ? 'selected' : '' }} data-fields="{{ $stadium->field_count }}">
                            {{ $stadium->name }} ({{ $stadium->field_count }} sân)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="field_number">Số Sân</label>
                <select name="field_number" id="field_number" class="form-control" required>
                    <!-- Tự động cập nhật khi chọn sân -->
                </select>
            </div>

            <div class="form-group">
                <label for="match_date">Ngày Thi Đấu</label>
                <input type="date" name="match_date" id="match_date" class="form-control" value="{{ \Carbon\Carbon::parse($match->match_date)->format('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label for="match_time">Chọn Ca Thi Đấu</label>
                <select name="match_time" id="match_time" class="form-control" required>
                    @php
                        $startTime = strtotime('06:00');
                        $endTime = strtotime('22:00');
                        $currentTime = \Carbon\Carbon::parse($match->match_date)->format('H:i'); // Lấy giờ hiện tại của trận đấu
                        while ($startTime < $endTime) {
                            $timeSlot = date('H:i', $startTime) . ' - ' . date('H:i', $startTime + 5400); // 90 phút = 5400 giây
                            $selected = ($currentTime == date('H:i', $startTime)) ? 'selected' : '';
                            echo "<option value='{$timeSlot}' {$selected}>{$timeSlot}</option>";
                            $startTime += 5400;
                        }
                    @endphp
                </select>
            </div>

            <div class="form-group">
                <label for="location">Địa Điểm</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ $match->location }}" required>
            </div>

            <button type="submit" class="btn btn-success">Cập Nhật Lịch Thi Đấu</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const stadiumSelect = document.getElementById("stadium_id");
            const fieldSelect = document.getElementById("field_number");

            function updateFieldNumbers() {
                const selectedOption = stadiumSelect.options[stadiumSelect.selectedIndex];
                const maxFields = selectedOption.getAttribute("data-fields") || 1;
                fieldSelect.innerHTML = "";
                
                // Tự động chọn số sân dựa trên dữ liệu từ match
                let selectedFieldNumber = {{ old('field_number', $match->field_number ?? 1) }};
                
                for (let i = 1; i <= maxFields; i++) {
                    const option = document.createElement("option");
                    option.value = i;
                    option.textContent = "Sân " + i;
                    if (i === selectedFieldNumber) {
                        option.selected = true;
                    }
                    fieldSelect.appendChild(option);
                }
            }

            stadiumSelect.addEventListener("change", updateFieldNumbers);
            updateFieldNumbers(); // Gọi lần đầu để cập nhật sân mặc định
        });
    </script>
@endsection