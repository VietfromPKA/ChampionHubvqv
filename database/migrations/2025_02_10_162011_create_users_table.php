<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->binary('avatar')->nullable(); // Thêm cột avatar
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('verification_token')->nullable();   //Sử dụng để xác thực tài khoản
            $table->string('reset_token')->nullable();  //Sử dụng để reset password
            $table->string('role')->default('user'); // Vai trò mặc định là 'user'
            $table->rememberToken();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
