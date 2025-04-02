# ChampionHub - Hệ Thống Quản Lý Giải Bóng Đá



---

## Giới Thiệu
ChampionHub là một nền tảng quản lý giải bóng đá chuyên nghiệp, được phát triển trên nền tảng PHP và Laravel Framework. Hệ thống hỗ trợ tổ chức, quản lý đội bóng, cầu thủ, lịch thi đấu, kết quả trận đấu và bảng xếp hạng, giúp tối ưu hóa công tác vận hành và theo dõi các giải đấu bóng đá một cách hiệu quả.

## Tính Năng Chính

### 🏆 Quản lý đội bóng
- Thêm, chỉnh sửa, xóa đội bóng
- Cập nhật thông tin đội bóng (tên, logo, huấn luyện viên, v.v.)

### ⚽ Quản lý cầu thủ
- Thêm, chỉnh sửa, xóa cầu thủ
- Gắn kết cầu thủ với đội bóng
- Theo dõi chỉ số và thông tin chuyên môn

### 📅 Quản lý giải đấu
- Tạo và thiết lập giải đấu
- Lập lịch thi đấu tự động
- Hỗ trợ nhiều thể thức thi đấu (vòng tròn, loại trực tiếp)

### 📊 Quản lý kết quả
- Cập nhật kết quả trận đấu
- Tự động tính toán và cập nhật bảng xếp hạng
- Thống kê chi tiết (bàn thắng, thẻ phạt, hiệu suất cầu thủ, v.v.)

### 🌍 Hiển thị công khai
- Cung cấp giao diện hiển thị lịch thi đấu, kết quả và bảng xếp hạng
- Tối ưu hóa trải nghiệm người dùng trên đa nền tảng

---

## Hướng Dẫn Cài Đặt
### 📌 Yêu Cầu Hệ Thống
- PHP 8.x
- Composer
- Laravel 10.x
- MySQL hoặc PostgreSQL
- Node.js và NPM (cho tài nguyên frontend)

### 🚀 Cài Đặt Dự Án
```sh
# Clone dự án
git clone https://github.com/VietfromPKA/ChampionHubvqv.git

# Di chuyển vào thư mục dự án
cd ChampionHubvqv

# Cài đặt dependencies
composer install
npm install

# Tạo file cấu hình môi trường
cp .env.example .env

# Tạo key ứng dụng
php artisan key:generate

# Cấu hình cơ sở dữ liệu trong .env và chạy migration
php artisan migrate

# Biên dịch tài nguyên frontend
npm run dev

# Khởi chạy server
php artisan serve
```

---

## 📂 Cấu Trúc Thư Mục
```
ChampionHubvqv/
├── app/                    # Xử lý logic ứng dụng
│   ├── Console/            # Lệnh Artisan
│   ├── Exceptions/         # Xử lý ngoại lệ
│   ├── Http/               
│   │   ├── Controllers/    # Điều khiển luồng xử lý
│   │   ├── Middleware/     # Lọc request HTTP
│   │   └── Requests/       # Xác thực dữ liệu đầu vào
│   ├── Models/             # Định nghĩa mô hình dữ liệu
│   └── Providers/          # Cấu hình dịch vụ
├── bootstrap/              # Bootstrap ứng dụng
├── config/                 # Cấu hình ứng dụng
├── database/               
│   ├── factories/          # Mẫu dữ liệu giả lập
│   ├── migrations/         # Quản lý cơ sở dữ liệu
│   └── seeders/            # Khởi tạo dữ liệu mẫu
├── public/                 # Tệp tĩnh (CSS, JS, hình ảnh)
├── resources/              # Tài nguyên giao diện
│   ├── css/                # CSS nguồn
│   ├── js/                 # JavaScript nguồn
│   └── views/              # Templates Blade
├── routes/                 # Định nghĩa routes
├── storage/                # Lưu trữ tạm thời và logs
├── tests/                  # Bộ kiểm thử
├── .env                    # Cấu hình môi trường
├── artisan                 # CLI Laravel
├── composer.json           # Cấu hình Composer
├── package.json            # Cấu hình NPM
└── README.md               # Tài liệu dự án
```

---

## 📌 Biểu Đồ UML
![UML Diagram](https://github.com/user-attachments/assets/efff87b3-fead-48ce-8b81-201e9a8e24c8)

---

## 📞 Thông Tin Liên Hệ
- **Tác giả 01**: Vũ Quốc Việt - 22010256
- **Tác giả 02**: Vũ Văn Mạnh - 22010497
- **GitHub**: [VietfromPKA](https://github.com/VietfromPKA)
- **Kho Mã Nguồn**: [ChampionHub Repository](https://github.com/VietfromPKA/ChampionHubvqv.git)

---

✨ *ChampionHub - Biến bóng đá trở nên chuyên nghiệp hơn!* ✨

