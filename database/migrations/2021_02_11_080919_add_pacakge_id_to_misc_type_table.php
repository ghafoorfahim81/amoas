<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPacakgeIdToMiscTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $typePackageKeyMap = [
        1 => 0,
        2 => 5,
        3 => 8,
        4 => 7,
        5 => 9,
        6 => 6,
        7 => 0,
        8 => 3,
    ];

    public function up()
    {
        Schema::table('miscellaneous_type', function (Blueprint $table) {
            $table->integer('package_id')->index()->nullable();
        });

        foreach ($this->typePackageKeyMap as $typeId => $pacakgeId) {
            \DB::table('miscellaneous_type')
                ->where('id', $typeId)
                ->update(['package_id' => $pacakgeId]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('miscellaneous_type', function (Blueprint $table) {
            $table->dropColumn('package_id');
        });
    }
}
