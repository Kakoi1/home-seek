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
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['room_id']); // adjust the foreign key name if necessary
            $table->dropColumn('room_id'); // adjust the column name if necessary
        });
    }

    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('room_id')->nullable(); // re-add the column if needed
            $table->foreign('room_id')->references('id')->on('rooms'); // adjust as necessary
        });
    }

};
