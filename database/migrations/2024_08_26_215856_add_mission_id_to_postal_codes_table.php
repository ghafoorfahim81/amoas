<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('postal_codes', function (Blueprint $table) {
            // unsigned integer column for the mission id
            $table->unsignedInteger('mission_id')->nullable();
            // foreign key constraint
            $table->foreign('mission_id')->references('id')->on('departments')->onDelete('set null');
            // index the place column
            $table->index('place');
            $table->index('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('postal_codes', function (Blueprint $table) {
            $table->dropIndex(['state']);
            $table->dropIndex(['place']);
            $table->dropForeign(['mission_id']);
            $table->dropColumn('mission_id');
        });
    }
};
