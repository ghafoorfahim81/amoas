<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostalPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postal_packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 191)->index();
            $table->string('address', 191)->index();
            $table->string('phone', 191)->index();
            $table->string('uid', 191)->index()->nullable();
            $table->string('status', 191)->index()->nullable();
            $table->string('post', 191)->nullable();
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('registrar_id');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('post', function (Blueprint $table) {
            $table->unsignedBigInteger('postal_id');
            $table->unsignedBigInteger('postable_id');
            $table->string('postable_type', 191)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postal_packages');
        Schema::dropIfExists('post');
    }
}
