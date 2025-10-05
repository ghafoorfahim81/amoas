<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_en', 250);
            $table->string('name_dr', 250)->nullable();
            $table->string('name_pa', 250)->nullable();
            $table->string('type', 30)->default('directorate');
            $table->unsignedInteger('parent_id');
            $table->string('code', 20)->default('SOME_TYPE_CODE');
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('departments');
    }
}
