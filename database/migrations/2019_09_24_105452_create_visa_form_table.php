<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_form', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('department_id');
            $table->string('serial_no', 191)->index()->nullable();
            $table->string('title', 191)->index();
            $table->string('family_name', 191)->index();
            $table->string('given_name', 191)->index();
            $table->string('father_name', 191)->index();
            $table->date('dob')->index();
            $table->unsignedInteger('birth_country')->index();
            $table->string('gender', 191)->index();
            $table->enum('marital_status', ['single', 'engaged', 'married', 'separated', 'divorced', 'widow/widower'])->index();
            $table->unsignedInteger('residence_country')->index();
            $table->string('nationality', 191)->index();
            $table->string('other_nationality', 191)->index()->nullable();
            $table->boolean('under_18')->default(false);
            $table->string('address');
            $table->string('email', 191)->index();
            $table->string('mobile', 191)->index()->nullable();
            $table->string('occupation', 191)->index()->nullable();
            $table->string('employer_name', 191)->index()->nullable();
            $table->string('employer_address')->nullable();
            $table->string('pre_employer_name')->nullable();
            $table->string('status', 191)->index();
            $table->string('pre_employer_address')->nullable();
            $table->unsignedInteger('visa_type')->index();
            $table->string('purpose', 191)->index();
            $table->date('entry_date')->index()->nullable();
            $table->integer('intend_duration')->nullable();
            $table->string('entry_point')->nullable();
            $table->integer('children_no')->nullable();
            $table->string('visit_places')->nullable();
            $table->string('af_address')->nullable();
            $table->string('visited_before')->nullable();
            $table->string('applied_visa')->nullable();
            $table->string('criminal_record')->nullable();
            $table->string('passport_type', 191)->index();
            $table->string('passport_no', 191)->index();
            $table->string('issue_place', 191)->index();
            $table->date('issue_date', 191)->index();
            $table->date('expire_date', 191)->index();
            $table->date('photo')->nullable();
            $table->unsignedInteger('registrar_id');
            $table->timestamps();
        });

        Schema::create('visa_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->index();
            $table->string('label_en')->nullable();
            $table->string('label_dr')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visa_form');
        Schema::dropIfExists('visa_types');
    }
}
