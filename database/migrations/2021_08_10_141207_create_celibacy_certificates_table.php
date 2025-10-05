<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCelibacyCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('celibacy_certificates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('serial_no', 100)->index()->nullable();
            $table->date('issue_date')->index()->nullable();
            $table->string('family_name', 191)->index()->nullable();
            $table->string('given_name', 191)->index()->nullable();
            $table->string('sex', 10)->index()->nullable();
            $table->date('dob')->index()->nullable();
            $table->string('pob', 100)->index()->nullable();
            $table->string('passport_no', 100)->index()->nullable();
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('registrar_id')->nullable();
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
        Schema::dropIfExists('celibacy_certificates');
    }
}
