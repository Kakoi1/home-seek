<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentFormsTable extends Migration
{
    public function up()
    {
        Schema::create('rent_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('dorm_id');
            $table->enum('term', ['short_term', 'long_term']);
            $table->date('start_date');
            $table->date('end_date')->nullable(); // For short-term rentals
            $table->integer('duration')->nullable(); // For long-term rentals
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('dorm_id')->references('id')->on('dorms');
        });
    }


    public function down()
    {
        Schema::dropIfExists('rent_forms');
    }
}