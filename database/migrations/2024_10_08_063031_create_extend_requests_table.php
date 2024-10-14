<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('extend_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->date('new_end_date');
            $table->enum('term', ['short_term', 'long_term']);
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();

            // Foreign key to link to the rent form
            $table->foreign('form_id')->references('id')->on('rent_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extend_requests');
    }
};
