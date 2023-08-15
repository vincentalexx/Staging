<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCongregationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('congregations', function (Blueprint $table) {
            $table->id();

            $table->string('id_card')->nullable();

            $table->string('nama_lengkap');
            $table->string('jenis_kelamin');
            $table->string('sekolah');
            $table->string('angkatan');
            $table->date('tgl_lahir');
            $table->string('alamat');
            $table->string('no_wa');
            $table->string('hobi');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('congregations');
    }
}
