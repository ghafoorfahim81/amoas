<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('payment_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->index();
            $table->unsignedDecimal('amount', 14, 2);
            $table->string('currency', 3)->index()->default('€');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('receipts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('receipt_no', 50)->index();
            $table->date('date')->index();
            $table->string('client_name', 191)->index()->nullable();
            $table->string('id_card', 191)->index()->nullable();
            $table->unsignedInteger('service_id')->index();
            $table->unsignedInteger('received_by')->index();
            $table->unsignedInteger('accountant_id')->index();
            $table->unsignedInteger('clearance_id')->nullable();
            $table->unsignedInteger('registrar_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('service_id')
                ->references('id')
                ->on('payment_services')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipts');
        Schema::dropIfExists('payment_services');
    }
}
