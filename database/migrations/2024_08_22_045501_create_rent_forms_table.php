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
            $table->date('start_date');
            $table->integer('duration'); // duration in months
            $table->string('status')->default('pending');
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('dorm_id')->references('id')->on('dorms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rent_forms');
    }
}

