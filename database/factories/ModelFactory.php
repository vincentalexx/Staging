<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'last_login_at' => $faker->dateTime,
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Congregation::class, static function (Faker\Generator $faker) {
    return [
        'nama_lengkap' => $faker->name,
        'sekolah' => $faker->sentence,
        'jenis_kelamin' => $faker->randomElement(['laki_laki', 'perempuan']),
        'tgl_lahir' => $faker->date(),
        'alamat' => $faker->sentence,
        'angkatan' => 'G21',
        'no_wa' => $faker->phoneNumber(),
        'hobi' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Budget::class, static function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTime,
        'divisi' => $faker->sentence,
        'nama_periode' => $faker->sentence,
        'periode' => $faker->date(),
        'total_budget' => $faker->randomFloat,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\BudgetUsage::class, static function (Faker\Generator $faker) {
    return [
        'budget_id' => $faker->sentence,
        'budget_detail_id' => $faker->sentence,
        'tanggal' => $faker->date(),
        'jenis_budget' => $faker->sentence,
        'deskripsi' => $faker->sentence,
        'jumlah_orang' => $faker->randomNumber(5),
        'total' => $faker->randomFloat,
        'reimburs' => $faker->randomFloat,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Discipleship::class, static function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTime,
        'divisi' => $faker->sentence,
        'nama_pembinaan' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        'user_id' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\DiscipleshipDetail::class, static function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTime,
        'created_by' => $faker->sentence,
        'deleted_at' => null,
        'discipleship_id' => $faker->sentence,
        'divisi' => $faker->sentence,
        'judul' => $faker->sentence,
        'tanggal' => $faker->date(),
        'updated_at' => $faker->dateTime,
        'updated_by' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Izin::class, static function (Faker\Generator $faker) {
    return [
        'nama' => $faker->sentence,
        'congregation_id' => $faker->sentence,
        'angkatan' => $faker->sentence,
        'kegiatan' => $faker->sentence,
        'tgl_kegiatan' => $faker->date(),
        'keterangan' => $faker->sentence,
        'alasan' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
        
        
    ];
});
