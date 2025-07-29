<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_country_id')->unique(); // Sports Monk id
            $table->string('name', 255);
            $table->string('fifa_name', 3)->nullable();
            $table->string('image_path', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
