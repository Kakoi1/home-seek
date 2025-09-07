<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rent_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('dorm_id')->constrained();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('guest');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'active', 'approved', 'rejected', 'cancelled', 'completed'])->default('pending');
            $table->longText('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rent_forms');
    }
};