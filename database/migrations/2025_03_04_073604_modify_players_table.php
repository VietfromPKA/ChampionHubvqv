<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropUnique('players_email_unique'); // Xóa unique trên email
        });
    }


    public function down()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->unique('email'); // Thêm lại unique nếu rollback
        });
    }

};
