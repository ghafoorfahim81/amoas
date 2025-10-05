<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingPassportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traceable_passports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid', 191)->index()->nullable();
            $table->string('family_name', 191)->index()->nullable();
            $table->string('given_name', 191)->index()->nullable();
            $table->string('passport_no', 191)->index()->nullable();
            $table->unsignedInteger('department_id')->nullable();
            $table->string('status', 191)->index()->nullable();
            $table->date('date')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('traceable_passports');
    }
}
