<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_checklists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->index();
            $table->boolean('status')->default(true);
        });

        Schema::create('checklist_post_pivot', function (Blueprint $table) {
            $table->integer('checklist_id');
            $table->bigInteger('post_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_checklists');
        Schema::dropIfExists('checklist_post_pivot');
    }
}
