<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarriageCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marriage_certificates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('serial_no', 100)->index()->nullable();
            $table->date('issue_date')->index()->nullable();
            $table->date('dom')->index()->nullable();
            $table->string('pom', 100)->index()->nullable();
            $table->string('husband_family_name', 191)->index()->nullable();
            $table->string('husband_given_name', 191)->index()->nullable();
            $table->string('husband_previous_name', 191)->index()->nullable();
            $table->string('husband_passport_no', 100)->index()->nullable();
            $table->date('husband_dob')->index()->nullable();
            $table->string('husband_pob', 100)->index()->nullable();
            $table->string('wife_family_name', 191)->index()->nullable();
            $table->string('wife_given_name', 191)->index()->nullable();
            $table->string('wife_previous_name', 191)->index()->nullable();
            $table->string('wife_passport_no', 100)->index()->nullable();
            $table->date('wife_dob')->index()->nullable();
            $table->string('wife_pob', 100)->index()->nullable();
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
        Schema::dropIfExists('marriage_certificates');
    }
}
