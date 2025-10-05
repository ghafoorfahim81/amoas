<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('booking_id');
            $table->string('full_name', 191)->index();
            $table->string('email', 191)->index();
            $table->string('phone', 191)->index();
            $table->string('id_card', 191)->index();
            $table->string('postal', 191)->index();
            $table->string('address', 191)->index();
            $table->timestamps();
        });

        Schema::create('participants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('info_id');
            $table->string('full_name', 191)->index();
            $table->string('id_card', 191)->index();
            $table->string('relation', 191)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_info');
        Schema::dropIfExists('participants');
    }
}
