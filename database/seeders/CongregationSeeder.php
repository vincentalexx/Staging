<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CongregationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $congregations = factory(\App\Models\Congregation::class, 100)->make();

    	foreach ($congregations->toArray() as $key => $congregation) {
    		$congregation = factory('App\Models\Congregation')->create();
    	}
    }
}
