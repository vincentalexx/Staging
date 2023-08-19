<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAndChangeSomeFieldInCongregationAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('congregation_attendances', function (Blueprint $table) {
            $table->time('jam_datang')->nullable()->change();
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
            $table->time('jam_datang')->change();
        });
    }
}
