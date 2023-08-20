<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTempatKebaktianInCongregationAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('congregation_attendances', function (Blueprint $table) {
            $table->string('tempat_kebaktian')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('congregation_attendances', function (Blueprint $table) {
            $table->dropColumn('tempat_kebaktian');
        });
    }
}
