<?php

// database/migrations/xxxx_xx_xx_create_reports_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID of the user submitting the report
            $table->unsignedBigInteger('reported_id'); // ID of the user or property being reported
            $table->string('reported_type'); // Type: 'user' or 'property'
            $table->unsignedBigInteger('dorm_id')->nullable(); // Property's dorm ID (optional)
            $table->string('reason'); // Reason for the report
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dorm_id')->references('id')->on('dorms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
