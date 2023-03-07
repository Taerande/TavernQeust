<?php

namespace Database\Factories;

use App\Models\Character;
use App\Models\Game;
use App\Models\Schedule;
use App\Models\User;
use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

class PartyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $charset = Character::all(['user_id']);

        $newList = [];
        foreach ($charset as $char) {
            $newList[] = $char['user_id'];
        }

        $userId = $this->faker->randomElement($newList);


        return [
            'user_id' => $userId,
            'game_id' => Game::where('name', 'World_Of_Warcraft')->first()->id,
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraphs(3, true),
        ];
    }
}
