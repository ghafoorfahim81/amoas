<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('department_id')->default(0);
            $table->string('serial_no', 191)->index();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('package_id')->unsigned()->index();
            $table->date('booking_date');
            $table->string('booking_time', 50)->index();
            $table->string('google_calendar_event_id')->nullable();
            $table->string('email')->nullable();
            $table->string('booking_type')->nullable();
            $table->string('status')->default('Processing');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
