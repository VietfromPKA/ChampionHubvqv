<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('stadium_images', function (Blueprint $table) {
            $table->id(); // ID tự động tăng
            $table->foreignId('stadium_id')->constrained('stadiums')->onDelete('cascade'); // Khóa ngoại liên kết với bảng 'stadiums'
            $table->string('image_url'); // Liên kết ảnh
            $table->timestamps(); // created_at và updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('stadium_images');
    }
};
