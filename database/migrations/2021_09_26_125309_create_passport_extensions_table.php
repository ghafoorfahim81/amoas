<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassportExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passport_extensions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pass_no')->nullable();
            $table->string('given_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('status')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('place')->nullable();
            $table->string('street')->nullable();
            $table->string('house_no')->nullable();
            $table->string('phone')->nullable();
            $table->string('invoice_no')->nullable();
            $table->unsignedBigInteger('family_id')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('passport_extensions');
    }
}
