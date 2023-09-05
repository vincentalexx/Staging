<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCongregationDiscipleshipDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('congregation_discipleship_detail', function (Blueprint $table) {
            $table->id();

            $table->foreignId('congregation_id')->constrained();
            $table->foreignId('discipleship_detail_id')->constrained();

            $table->string('keterangan')->nullable();
            $table->text('alasan')->nullable();

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
        Schema::dropIfExists('congregation_discipleship_detail');
    }
}
