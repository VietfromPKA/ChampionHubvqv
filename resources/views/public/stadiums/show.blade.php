@extends('layouts.app')

<link href="{{ asset('css/stadium_show.css') }}" rel="stylesheet">

@section('title', 'Chi tiết sân bóng')

@section('content')
    <div class="container stadium-detail-container">
        <h2 class="card-title stadium-name">Sân bóng: {{ $stadium->name }}</h2>

        <div class="stadium-images">
            {{-- Hiển thị ảnh nhiều ảnh nếu có --}}
            @if($stadium->images->isNotEmpty())
                <div class="row stadium-gallery">
                    @foreach($stadium->images as $image)
                        <div class="col-md-3 stadium-image-container">
                            <div class="stadium-image-wrapper">
                                <img src="{{ $image->image_url }}" class="stadium-image mb-2"
                                    alt="Ảnh sân bóng {{ $stadium->name }}">

                                {{-- Nút xóa ảnh --}}
                                @if(auth()->check() && auth()->user()->role === 'admin')
                                    <form action="{{ route('stadiums.deleteImage', $image->id) }}" method="POST"
                                        class="image-delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete-image-btn"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa ảnh này?')">Xóa ảnh</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="no-images-message">Chưa có ảnh sân bóng.</p>
            @endif
            {{-- Nút thêm ảnh --}}
            @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="upload-section">
                    <form action="{{ route('stadiums.uploadImage', $stadium->id) }}" method="POST" enctype="multipart/form-data"
                        class="upload-form">
                        @csrf
                        <div class="mb-3 file-input-group">
                            <label class="form-label upload-label">Tải ảnh mới</label>
                            <input type="file" name="image[]" class="form-control file-input" multiple>
                        </div>
                        <button type="submit" class="btn btn-success upload-btn">Tải lên</button>
                    </form>
                </div>
            @endif
        </div>
        <div class="stadium-info">
            <p class="stadium-tt"><strong>Vị trí:</strong> {{ $stadium->location }}</p>
            <p class="stadium-tt"><strong>Giá thuê:</strong> {{ number_format($stadium->price_per_hour) }}
                VNĐ/giờ</p>
            <p class="stadium-tt"><strong>Số điện thoại:</strong> {{ $stadium->phone }}</p>
            <p class="stadium-tt"><strong>Mô tả:</strong> {{ $stadium->description }}</p>
            <p class="stadium-tt"><strong>Số lượng sân:</strong> {{ $stadium->field_count }}</p>
            <p class="stadium-tt">Lịch chi tiết từng sân:</p>

            <div class="stadium-navbar">
                @for ($i = 1; $i <= $stadium->field_count; $i++)
                    <div class="stadium-item">
                        <button class="stadium-toggle" onclick="toggleField({{ $i }})">Sân {{ $i }}</button>
                    </div>
                @endfor
            </div>
        </div>

        <div class="stadium-lich-container">
            @for ($i = 1; $i <= $stadium->field_count; $i++)
                <div class="stadium-lich" id="lich-{{ $i }}" style="display: none;">
                    <div class="week-navigation">
                        <button class="btn btn-secondary" onclick="changeWeek({{ $i }}, -1)">Tuần trước</button>
                        <h4 class="lich-title">
                            Lịch đặt sân {{ $i }} (Tuần:
                            <span id="start-week-{{ $i }}">{{ \Carbon\Carbon::now()->startOfWeek()->format('d/m/Y') }}</span> -
                            <span id="end-week-{{ $i }}">{{ \Carbon\Carbon::now()->endOfWeek()->format('d/m/Y') }}</span>)
                        </h4>
                        <button class="btn btn-secondary" onclick="changeWeek({{ $i }}, 1)">Tuần sau</button>
                    </div>

                    <table class="lich-table" id="lich-table-{{ $i }}">
                        <thead>
                            <tr>
                                <th>Giờ</th>
                                <th>T2</th>
                                <th>T3</th>
                                <th>T4</th>
                                <th>T5</th>
                                <th>T6</th>
                                <th>T7</th>
                                <th>CN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($hour = 6; $hour < 22; $hour += 1.5)
                                            @php
                                                $startHour = floor($hour);
                                                $startMinute = ($hour - $startHour) * 60;
                                                $endHour = floor($hour + 1.5);
                                                $endMinute = ($hour + 1.5 - $endHour) * 60;
                                                $timeRange = sprintf('%02d:%02d - %02d:%02d', $startHour, $startMinute, $endHour, $endMinute);
                                            @endphp
                                            <tr>
                                                <td>{{ $timeRange }}</td>
                                                @for ($day = 1; $day <= 7; $day++)
                                                    <td id="field-{{ $i }}-day-{{ $day }}-hour-{{ $startHour }}-minute-{{ $startMinute }}"></td>
                                                @endfor
                                            </tr>
                            @endfor
                        </tbody>

                    </table>
                </div>
            @endfor
        </div>

        <a href="{{ route('stadiums.index') }}" class="btn btn-primary back-btn mt-3">Quay lại</a>
    </div>

    <script>
        const matches = @json($matches);

        function toggleField(fieldId) {
            document.querySelectorAll('.stadium-lich').forEach(field => field.style.display = 'none');
            document.getElementById('lich-' + fieldId).style.display = 'block';
            updateSchedule(fieldId);
        }

        function changeWeek(fieldId, direction) {
            const startWeek = document.getElementById(`start-week-${fieldId}`);
            const endWeek = document.getElementById(`end-week-${fieldId}`);
            const startDate = new Date(startWeek.textContent.split('/').reverse().join('-'));
            const endDate = new Date(endWeek.textContent.split('/').reverse().join('-'));

            startDate.setDate(startDate.getDate() + (direction * 7));
            endDate.setDate(endDate.getDate() + (direction * 7));

            const formatDate = date => `${date.getDate().toString().padStart(2, '0')}/${(date.getMonth() + 1).toString().padStart(2, '0')}/${date.getFullYear()}`;
            startWeek.textContent = formatDate(startDate);
            endWeek.textContent = formatDate(endDate);

            updateSchedule(fieldId);
        }

        function updateSchedule(fieldId) {
            const startWeekText = document.getElementById(`start-week-${fieldId}`).textContent;
            const endWeekText = document.getElementById(`end-week-${fieldId}`).textContent;

            const startDateParts = startWeekText.split('/');
            const endDateParts = endWeekText.split('/');
            const startDate = new Date(`${startDateParts[2]}-${startDateParts[1]}-${startDateParts[0]}`);
            const endDate = new Date(`${endDateParts[2]}-${endDateParts[1]}-${endDateParts[0]}`);

            const filteredMatches = matches.filter(match => {
                const matchDate = new Date(match.match_date);
                matchDate.setHours(0, 0, 0, 0);

                return (
                    match.stadium_id === {{ $stadium->id }} &&
                    match.field_number === fieldId &&
                    matchDate >= startDate &&
                    matchDate <= endDate
                );
            });

            const table = document.getElementById(`lich-table-${fieldId}`).getElementsByTagName('tbody')[0];
            for (let row of table.rows) {
                for (let i = 1; i < row.cells.length; i++) {
                    row.cells[i].innerHTML = ''; // 🔹 Xóa nội dung trước đó
                    row.cells[i].classList.remove('booked');
                }
            }

            filteredMatches.forEach(match => {
                const matchDate = new Date(match.match_date);
                let dayOfWeek = matchDate.getDay();
                dayOfWeek = dayOfWeek === 0 ? 7 : dayOfWeek; // 🔹 Chủ Nhật thành Thứ 7

                const matchHour = parseInt(match.match_date.split(' ')[1].split(':')[0], 10);
                const matchMinute = parseInt(match.match_date.split(' ')[1].split(':')[1], 10);

                const slotId = `field-${fieldId}-day-${dayOfWeek}-hour-${matchHour}-minute-${matchMinute}`;
                const cell = document.getElementById(slotId);

                if (cell) {
                    // 🔹 Lấy tên giải đấu
                    const tournamentName = match.tournament ? match.tournament.name : "Trận tự do";

                    // 🔹 Hiển thị tên giải đấu lên trên, các đội xuống dòng
                    cell.innerHTML = `<strong>${tournamentName}</strong><br>${match.team1.name} vs ${match.team2.name}`;

                    // 🔹 Bôi đỏ ô này
                    cell.classList.add('booked');
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            toggleField(1);
        });
    </script>
@endsection