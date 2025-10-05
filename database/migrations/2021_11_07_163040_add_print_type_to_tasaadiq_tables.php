<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrintTypeToTasaadiqTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('celibacy_certificates', function (Blueprint $table) {
            $table->string('print_type', 10)->index()->after('issue_date')->default('old');
        });
        Schema::table('birth_certificates', function (Blueprint $table) {
            $table->string('print_type', 10)->index()->after('issue_date')->default('old');
        });
        Schema::table('marriage_certificates', function (Blueprint $table) {
            $table->string('print_type', 10)->index()->after('issue_date')->default('old');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('celibacy_certificates', function (Blueprint $table) {
            $table->dropColumn('print_type');
        });
        Schema::table('birth_certificates', function (Blueprint $table) {
            $table->dropColumn('print_type');
        });
        Schema::table('marriage_certificates', function (Blueprint $table) {
            $table->dropColumn('print_type');
        });
    }
}
