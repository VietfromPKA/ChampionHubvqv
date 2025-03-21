<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('match_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id')->nullable(); // Giải đấu (có thể null nếu là trận cá nhân)
            $table->unsignedBigInteger('team1_id'); // Đội 1
            $table->unsignedBigInteger('team2_id'); // Đội 2
            $table->unsignedBigInteger('stadium_id'); // Sân thi đấu
            $table->enum('schedule_type', ['tournament', 'individual']); // Loại lịch
            $table->dateTime('match_date'); // Ngày giờ thi đấu
            $table->string('location'); // Địa điểm (có thể khác với sân)
            $table->string('scoreTeam1')->nullable(); // Kết quả team 1(có thể null nếu chưa thi đấu)
            $table->string('scoreTeam2')->nullable(); // Kết quả team 2(có thể null nếu chưa thi đấu)
            $table->timestamps();

            // Liên kết khóa ngoại
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->foreign('team1_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('team2_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('stadium_id')->references('id')->on('stadiums')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('match_schedules');
    }
};
