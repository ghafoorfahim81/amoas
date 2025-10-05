<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNecessaryFieldsInReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->integer('quantity')->after('clearance_id')->nullable()->default(1);
            $table->bigInteger('bill_no')->after('clearance_id')->nullable();
            $table->string('payment_method', 50)->index()->after('clearance_id')->default('cash');
            $table->text('remarks')->after('registrar_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'bill_no', 'remarks', 'quantity']);
        });
    }
}
