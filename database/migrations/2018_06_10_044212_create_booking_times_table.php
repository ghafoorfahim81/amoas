<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_times', function (Blueprint $table) {
            $table->increments('id');
            $table->string('day');
            $table->string('opening_time');
            $table->string('closing_time');
            $table->boolean('is_off_day')->default(0);
            $table->timestamps();
        });

        Schema::create('holydays', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_times');
        Schema::dropIfExists('holydays');
    }
}
