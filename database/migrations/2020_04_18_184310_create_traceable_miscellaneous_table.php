<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraceableMiscellaneousTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traceable_miscellaneous', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid', 191)->index()->nullable();
            $table->unsignedInteger('department_id')->nullable();
            $table->unsignedInteger('doc_type')->index();
            $table->string('noti_lang', 20)->index()->nullable();
            $table->string('alt_email', 100)->index()->nullable();
            $table->string('phone_no', 60)->index()->nullable();
            $table->text('descriptions')->nullable();
            $table->unsignedInteger('registrar_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('miscellaneous_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 191)->index()->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('traceable_miscellaneous');
        Schema::dropIfExists('miscellaneous_type');
    }
}
