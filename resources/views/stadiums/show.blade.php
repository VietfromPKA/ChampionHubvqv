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
                        <h4 class="lich-title">Lịch đặt sân {{ $i }} (Tuần:
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
                            @for ($time = 6; $time <= 21; $time += 1.5)
                                            @php
                                                $hour = floor($time); // Lấy phần nguyên (giờ)
                                                $minute = ($time - $hour) * 60; // Lấy phần thập phân và chuyển thành phút
                                                $startTime = sprintf('%02d:%02d', $hour, $minute); // Định dạng HH:MM
                                                $endHour = floor($time + 1.5); // Giờ kết thúc
                                                $endMinute = (($time + 1.5) - $endHour) * 60; // Phút kết thúc
                                                $endTime = sprintf('%02d:%02d', $endHour, $endMinute); // Định dạng HH:MM (kết thúc)
                                                $timeDisplay = $startTime . ' - ' . $endTime; // Khoảng thời gian
                                            @endphp
                                            <tr>
                                                <td>{{ $timeDisplay }}</td>
                                                <td id="field-{{ $i }}-day-1-hour-{{ $hour }}-minute-{{ $minute }}"></td>
                                                <td id="field-{{ $i }}-day-2-hour-{{ $hour }}-minute-{{ $minute }}"></td>
                                                <td id="field-{{ $i }}-day-3-hour-{{ $hour }}-minute-{{ $minute }}"></td>
                                                <td id="field-{{ $i }}-day-4-hour-{{ $hour }}-minute-{{ $minute }}"></td>
                                                <td id="field-{{ $i }}-day-5-hour-{{ $hour }}-minute-{{ $minute }}"></td>
                                                <td id="field-{{ $i }}-day-6-hour-{{ $hour }}-minute-{{ $minute }}"></td>
                                                <td id="field-{{ $i }}-day-7-hour-{{ $hour }}-minute-{{ $minute }}"></td>
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
        function toggleField(fieldId) {
            const allFields = document.querySelectorAll('.stadium-lich');
            const targetField = document.getElementById('lich-' + fieldId);

            // Ẩn tất cả các lịch sân trước khi hiển thị sân được chọn
            allFields.forEach(field => {
                if (field !== targetField) {
                    field.style.display = 'none';
                }
            });

            // Chuyển đổi trạng thái hiển thị của sân được chọn
            if (targetField.style.display === 'none' || targetField.style.display === '') {
                targetField.style.display = 'block';
            } else {
                targetField.style.display = 'none';
            }
        }

        function changeWeek(fieldId, direction) {
            // Lấy ngày bắt đầu và kết thúc tuần hiện tại
            const startWeekElement = document.getElementById(`start-week-${fieldId}`);
            const endWeekElement = document.getElementById(`end-week-${fieldId}`);

            // Chuyển đổi ngày từ chuỗi sang đối tượng Date
            const currentStartDate = new Date(startWeekElement.textContent.split('/').reverse().join('-'));
            const currentEndDate = new Date(endWeekElement.textContent.split('/').reverse().join('-'));

            // Tính toán ngày bắt đầu và kết thúc của tuần mới
            const newStartDate = new Date(currentStartDate);
            const newEndDate = new Date(currentEndDate);

            if (direction === 1) {
                // Tuần sau: thêm 7 ngày
                newStartDate.setDate(newStartDate.getDate() + 7);
                newEndDate.setDate(newEndDate.getDate() + 7);
            } else if (direction === -1) {
                // Tuần trước: trừ 7 ngày
                newStartDate.setDate(newStartDate.getDate() - 7);
                newEndDate.setDate(newEndDate.getDate() - 7);
            }

            // Định dạng lại ngày thành chuỗi "dd/mm/yyyy"
            const formatDate = (date) => {
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}/${month}/${year}`;
            };

            // Cập nhật ngày trên giao diện
            startWeekElement.textContent = formatDate(newStartDate);
            endWeekElement.textContent = formatDate(newEndDate);

            // Gọi hàm để cập nhật dữ liệu lịch (nếu cần)
            updateSchedule(fieldId, newStartDate, newEndDate);
        }

        function updateSchedule(fieldId, startDate, endDate) {
            // Gọi API hoặc cập nhật dữ liệu lịch dựa trên fieldId, startDate, và endDate
            console.log(`Cập nhật lịch cho sân ${fieldId} từ ${startDate} đến ${endDate}`);
            // Thêm logic cập nhật dữ liệu lịch ở đây
        }
    </script>


@endsection