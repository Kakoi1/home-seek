<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->bigInteger('fb_id')->nullable();
            $table->string('google_id', 100)->nullable();
            $table->string('profile_picture')->nullable();
            $table->longText('address')->nullable();
            $table->rememberToken();
            $table->boolean('active_status')->default(false);
            $table->boolean('verify_status')->default(false);
            $table->string('role')->nullable();
            $table->tinyInteger('strike')->default(3);
            $table->longText('note')->nullable();
            $table->integer('email_verification_code')->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('stripe_account_id')->unique()->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};