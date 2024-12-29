<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id'); // Liên kết với giải đấu
            $table->unsignedBigInteger('team1_id'); // Đội 1
            $table->unsignedBigInteger('team2_id'); // Đội 2
            $table->dateTime('match_date'); // Ngày giờ thi đấu
            $table->string('location'); // Địa điểm
            $table->timestamps();

            // Liên kết khóa ngoại
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->foreign('team1_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('team2_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('games');
    }
}
