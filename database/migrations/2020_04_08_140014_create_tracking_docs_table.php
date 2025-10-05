<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traceable_docs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('department_id')->nullable();
            $table->unsignedBigInteger('traceable_id');
            $table->string('traceable_type', 191)->index();
            $table->string('uid', 191)->index()->nullable();
            $table->string('status', 191)->index()->nullable();
            $table->boolean('is_public')->index()->default(false);
            $table->string('email', 191)->index()->nullable();
            $table->string('applicant', 191)->index()->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('traceable_docs');
    }
}
