<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('department_id');
            $table->string('name', 191)->index();
            $table->string('last_name', 191)->index();
            $table->string('father_name', 191)->index();
            $table->string('grand_father_name', 191)->index();
            $table->string('birth_place')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('living_duration')->nullable();
            $table->string('living_duration_unit', 20)->nullable();
            $table->string('last_trip', 11)->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();
            $table->unsignedInteger('service_id');
            $table->string('new_absence_tazkira_case')->nullable();
            $table->unsignedInteger('original_village');
            $table->unsignedInteger('original_district');
            $table->unsignedInteger('original_province');
            $table->string('current_city', 191)->index()->nullable();
            $table->string('zip_code', 191)->index()->nullable();
            $table->string('current_country', 191)->index()->nullable();
            $table->smallInteger('height')->nullable();
            $table->string('eyes')->nullable();
            $table->string('skin')->nullable();
            $table->string('hair')->nullable();
            $table->string('other')->nullable();
            $table->string('d_name', 191)->index();
            $table->string('d_last_name', 191)->index();
            $table->string('d_father_name', 191)->nullable();
            $table->string('d_contact', 191)->index();

            $table->string('sibling_name', 191)->index();
            $table->string('sibling_last_name', 191)->index();
            $table->string('sibling_father_name', 191)->index();
            $table->string('sibling_grand_father_name')->nullable();
            $table->unsignedInteger('sibling_id')->nullable();
            $table->string('page_no')->index();
            $table->string('version_no')->index();
            $table->string('note_no')->index();
            $table->string('year')->index();
            $table->string('month')->index();
            $table->string('day')->index();
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->index();
            $table->string('label_en')->nullable();
            $table->string('label_dr');

        });

        Schema::create('provinces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->index();
            $table->string('label_en')->nullable();
            $table->string('label_dr');
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->index();
            $table->string('label_en')->nullable();
            $table->string('label_dr');
        });

        Schema::create('village', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->index();
            $table->string('label_en')->nullable();
            $table->string('label_dr');
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 191)->index();
            $table->string('name_en', 191)->index();
            $table->string('name_dr', 191)->index();
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('contactable_id');
            $table->string('contactable_type', 191)->index();
            $table->string('contact');
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verifications');
        Schema::dropIfExists('services');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('village');
        Schema::dropIfExists('contacts');
    }
}
