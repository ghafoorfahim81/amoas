<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverableDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverable_docs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('postal_id');
            $table->string('doc_type', 191)->index()->nullable();
            $table->string('uid', 191)->index()->nullable();
            $table->string('name', 191)->index()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('postal_packages', function (Blueprint $table) {
            $table->string('email', 191)->index()->nullable()->after('post');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliverable_docs');
        Schema::table('postal_packages', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
}
