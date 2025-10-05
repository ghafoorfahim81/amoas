<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDate2PostalPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('postal_packages', function (Blueprint $table) {
            $table->string('place', 191)->index()->nullable()->after('post');
            $table->string('date', 191)->index()->nullable()->after('post');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('postal_packages', function (Blueprint $table) {
            $table->dropColumn('place');
            $table->dropColumn('date');
        });
    }
}
