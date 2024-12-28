<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('coach_name')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // liên kết với bảng user
            $table->foreignId('tournament_id')->constrained()->onDelete('cascade'); // Liên kết với bảng tournaments
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
