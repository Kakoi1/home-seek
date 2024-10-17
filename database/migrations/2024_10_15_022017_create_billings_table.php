<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('rent_form_id');
            $table->decimal('amount', 10, 2);
            $table->date('billing_date');
            $table->string('status')->default('pending'); // pending, paid, etc.
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('rent_form_id')->references('id')->on('rent_forms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('billings');
    }
}
