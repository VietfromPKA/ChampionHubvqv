@extends('layouts.app')
<link href="{{ asset('css/stadium.css') }}" rel="stylesheet">
@section('content')
    <div class="container">
        <h2>{{ isset($stadium) ? 'Chỉnh sửa sân bóng' : 'Thêm sân bóng mới' }}</h2>

        <form action="{{ isset($stadium) ? route('stadiums.update', $stadium->id) : route('stadiums.store') }}"
            method="POST">
            @csrf
            @if(isset($stadium))
                @method('PUT')
            @endif

            <div class="form-column">
                <div class="mb-3">
                    <label class="form-label">Tên sân bóng</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $stadium->name ?? '') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $stadium->phone ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description"
                        class="form-control">{{ old('description', $stadium->description ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá thuê theo giờ (VNĐ)</label>
                    <input type="number" name="price_per_hour" class="form-control"
                        value="{{ old('price_per_hour', $stadium->price_per_hour ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số lượng sân</label>
                    <input type="number" name="field_count" class="form-control"
                        value="{{ old('field_count', $stadium->field_count ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Địa chỉ sân bóng</label>
                    <input type="text" name="location" id="address" class="form-control" placeholder="Nhập địa chỉ" required
                        value="{{ old('location', $stadium->location ?? '') }}">
                </div>

                <div class="hidden-inputs">
                    <input type="hidden" id="latitude" name="latitude"
                        value="{{ old('latitude', $stadium->latitude ?? 21.0285) }}">
                    <input type="hidden" id="longitude" name="longitude"
                        value="{{ old('longitude', $stadium->longitude ?? 105.8542) }}">
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn btn-primary">{{ isset($stadium) ? 'Cập nhật' : 'Thêm mới' }}</button>
                    <a href="{{ route('stadiums.index') }}" class="btn btn-primary">Quay lại</a>
                </div>

            </div>

            <div class="map-column">
                <div class="map-label">Chọn vị trí trên bản đồ</div>
                <div id="map" style="height: 100%; width: 40%;"></div>
            </div>
        </form>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        var defaultLat = {{ old('latitude', $stadium->latitude ?? 21.0285) }};
        var defaultLng = {{ old('longitude', $stadium->longitude ?? 105.8542) }};

        var map = L.map('map', { zoomControl: false }).setView([defaultLat, defaultLng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        // Thêm lại zoomControl ở vị trí khác (ví dụ: góc dưới phải)
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        var marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        marker.on('dragend', function (e) {
            var latLng = marker.getLatLng();
            document.getElementById('latitude').value = latLng.lat.toFixed(6);
            document.getElementById('longitude').value = latLng.lng.toFixed(6);
        });

        function searchAddress() {
            var address = document.getElementById('address').value;
            if (address.trim() === '') return;

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        var lat = parseFloat(data[0].lat);
                        var lon = parseFloat(data[0].lon);

                        map.setView([lat, lon], 15);
                        marker.setLatLng([lat, lon]);
                        document.getElementById('latitude').value = lat.toFixed(6);
                        document.getElementById('longitude').value = lon.toFixed(6);
                    }
                });
        }

        document.getElementById('address').addEventListener('input', function () {
            clearTimeout(this.timer);
            this.timer = setTimeout(searchAddress, 800);
        });

        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
            document.getElementById('longitude').value = e.latlng.lng.toFixed(6);
        });
    </script>
@endsection