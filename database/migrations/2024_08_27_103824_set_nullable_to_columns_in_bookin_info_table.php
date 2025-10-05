<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetNullableToColumnsInBookinInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_info', function (Blueprint $table) {
            // set id_card nullable
            $table->string('id_card')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_info', function (Blueprint $table) {
            // set id_card not nullable
            $table->string('id_card')->nullable(false)->change();
        });
    }
}
