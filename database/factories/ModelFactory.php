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
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Participant::class, static function (Faker\Generator $faker) {
    return [
        'id_card' => null,
        'nama' => $faker->name(),
        'kelas_sekarang' => $faker->randomElement(['5', '6', '7', '8', '9', '10', '11', '12', 'kuliah_t1', 'kuliah_t2', 'kuliah_t3', 'kuliah_t4', 'kuliah_lulus']),
        'gender' => $faker->randomElement(['laki_laki', 'perempuan']),
        'no_wa' => $faker->sentence,
        'nama_ortu' => $faker->sentence,
        'no_wa_ortu' => $faker->sentence,
        'email' => $faker->email,
        'lokasi_gereja' => $faker->randomElement(['gii_gardujati', 'non_gii_gardujati']),
        'transportasi_pergi' => $faker->randomElement(['berangkat_sendiri', 'transportasi_gereja']),
        'transportasi_pulang' => $faker->randomElement(['pulang_sendiri', 'transportasi_gereja']),
        'status_pembayaran' => $faker->randomElement(['bayar_sekarang', 'bayar_nanti']),
        'nilai_persembahan' => $faker->randomNumber(6),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Group::class, static function (Faker\Generator $faker) {
    return [
        'nama_kelompok' => $faker->sentence,
        'point_kelompok' => $faker->randomNumber(5),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Congregation::class, static function (Faker\Generator $faker) {
    return [
        'nama_lengkap' => $faker->sentence,
        'jenis_kelamin' => $faker->sentence,
        'kelas' => $faker->sentence,
        'tgl_lahir' => $faker->date(),
        'alamat' => $faker->sentence,
        'no_wa' => $faker->sentence,
        'hobi' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
        
        
    ];
});
