<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('match_schedules', function (Blueprint $table) {
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'canceled'])->default('scheduled');
        });
    }

    public function down()
    {
        Schema::table('match_schedules', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
