<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $participants = factory(\App\Models\Participant::class, 100)->make();

    	foreach ($participants->toArray() as $key => $participant) {
    		$participant = factory('App\Models\Participant')->create();
    	}
    }
}
