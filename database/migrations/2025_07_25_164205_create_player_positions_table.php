<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_position_id')->unique(); // Sports Monk id
            $table->string('name', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_positions');
    }
};
