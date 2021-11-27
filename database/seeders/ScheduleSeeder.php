<?php

namespace Database\Seeders;

use App\Models\Schedule;

use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schedule::create([
            'party_id' => 1,
            'start' => '2021-11-18 22:14:00',
            'end' => '2021-11-20 08:12:00',
        ]);
        Schedule::factory()->times(100)->create();
    }
}
