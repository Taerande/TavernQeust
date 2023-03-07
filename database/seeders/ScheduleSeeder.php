<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\Character;
use App\Models\Party;
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
        Schedule::factory()->times(300)->create()
            ->each(function ($schedule) {

                $partyDetail = Party::where('id', $schedule->party_id)->first();

                $leader = $partyDetail->characters()->wherePivot('grade', 'leader')->first();


                // $randCharacter = Character::wherePivot('party_id', $party_id)->inRandomOrder()->first();

                if (!empty($leader)) {
                    $schedule->characters()->where('id', $leader->id)->syncWithoutDetaching([
                        $leader->id => ['grade' => 'leader']
                    ]);
                };


                $charSet = Character::where('user_id', '!=', $leader->user_id)->get('id')->random(rand(0, 5));

                foreach ($charSet as $char) {
                    $schedule->characters()->syncWithoutDetaching([$char->id => ['grade' => 'member']]);
                };
            });
    }
}
