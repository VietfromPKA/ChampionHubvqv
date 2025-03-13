<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('stadiums', function (Blueprint $table) {
            $table->id(); // ID tự động tăng
            $table->string('name'); // Tên sân bóng
            $table->string('phone')->nullable(); // Số điện thoại liên hệ
            $table->text('description')->nullable(); // Thông tin chi tiết sân bóng
            $table->string('location'); // Vị trí sân
            $table->integer('price_per_hour'); // Giá thuê theo giờ
            $table->integer('field_count'); // Số lượng sân
            $table->text('encrypted_image')->nullable(); // Ảnh được mã hóa
            $table->timestamps(); // created_at và updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('stadiums');
    }
};
