<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIzinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('izin', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('angkatan');
            $table->string('kegiatan');
            $table->date('tgl_kegiatan');
            $table->string('alasan');

            $table->timestamps();
            $table->softDeletes();
        });
    }
}
