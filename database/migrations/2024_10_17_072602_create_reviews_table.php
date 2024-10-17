<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // User who will submit the review
            $table->unsignedBigInteger('room_id'); // Room being reviewed
            $table->unsignedBigInteger('dorm_id'); // Property being reviewed
            $table->unsignedTinyInteger('rating')->nullable(); // Rating can be null initially
            $table->text('comments')->nullable(); // Comments can be null initially
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('dorm_id')->references('id')->on('dorms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
