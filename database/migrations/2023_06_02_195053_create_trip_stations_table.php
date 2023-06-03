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
        Schema::create('trip_stations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained('trips')->cascadeOnDelete();
            $table->string('seat_id');
            $table->foreign('seat_id')->references('ulid')->on('seats')->onDelete('cascade');
            $table->timestamp('arrival_time')->nullable();;
            $table->timestamp('departure_time')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_stations');
    }
};
