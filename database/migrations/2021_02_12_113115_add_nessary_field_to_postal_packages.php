<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNessaryFieldToPostalPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('postal_packages', function (Blueprint $table) {
            $table->string('street')->nullable()->after('place');
            $table->string('house_no')->nullable()->after('post');
            $table->float('post_price')->index()->nullable()->after('email');
            $table->float('doc_price')->index()->nullable()->after('email');
            $table->unsignedBigInteger('booking_id')->index()->nullable()->after('department_id');
        });

        Schema::table('traceable_miscellaneous', function (Blueprint $table) {
            $table->float('price')->index()->nullable()->after('department_id');
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
            $table->dropColumn(['street', 'house_no', 'post_price', 'doc_price', 'booking_id']);
        });

        Schema::table('traceable_miscellaneous', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
}
