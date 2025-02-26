<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->decimal('latitude', 12, 10);  // -90 -> 90 = 90.0123456789
            $table->decimal('longitude', 13, 10); // -180 -> 180 = 180.0123456789
            $table->string('status', 50);
            $table->string('type', 50);
            $table->integer('max_delivery_distance');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
