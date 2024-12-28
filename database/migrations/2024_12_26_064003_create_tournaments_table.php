<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentsTable extends Migration
{
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Loại bỏ after('id')
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::table('tournaments', function (Blueprint $table) {
            // Xóa khóa ngoại trước khi xóa bảng
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('tournaments');
    }

}

