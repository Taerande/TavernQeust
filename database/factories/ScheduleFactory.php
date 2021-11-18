<?php

namespace Database\Factories;

use App\Models\Party;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $currentDateTime = $this->faker->dateTimeBetween('-1 week', '+1 week');

        $intervalDateTime = $this->faker->dateTimeBetween('+1 week', '+3 weeks');

        // $type = $this->faker->randomElements(['party_id','scan_id','mercenary_id']);
        $partySet = Party::all(['id']);

        $newList = [];
        
        foreach($partySet as $party)
        {
            $newList[] = $party['id'];
        }

        $partyId = $this->faker->randomElement($newList);


        return [
            'party_id' => $partyId,
            'start' => $currentDateTime->format('Y-m-d H:m'),
            'end' => $intervalDateTime->format('Y-m-d H:m'),
        ];
    }
}
