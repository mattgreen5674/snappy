<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_player_id')->unique(); // Sports Monk id
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->date('date_of_birth');
            $table->string('gender', 6);
            $table->unsignedBigInteger('parent_position_id');
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('nationality_id');
            $table->string('image_path', 255);
            $table->timestamps();

            $table->foreign('parent_position_id')->references('external_position_id')->on('player_positions');
            $table->foreign('position_id')->references('external_position_id')->on('player_positions');
            $table->foreign('nationality_id')->references('external_country_id')->on('countries');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
