<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email');
            $table->string('password');
            $table->rememberToken();

            $table->boolean('activated')->default(false);
            $table->boolean('forbidden')->default(false);
            $table->string('language', 2)->default('en');

            $table->softDeletes();
            $table->timestamps();

            $table->unique(['email', 'deleted_at']);
        });

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        if ($driver === 'pgsql') {
            Schema::table('users', static function (Blueprint $table) {
                DB::statement('CREATE UNIQUE INDEX users_email_null_deleted_at ON users (email) WHERE deleted_at IS NULL;');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
