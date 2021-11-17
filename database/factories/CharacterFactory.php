<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function(){
                $userCount = User::count();
                return rand(1,$userCount);
            },
            'game_id' => Game::where('name','World Of Warcraft')->first()->id,
            'name' => $this->faker->name(),
            'spec' => $this->faker->randomElement(
                ['수드','조드','야드','회드','정술','복술','고술','신기','징기','보기','분전','무전','전탱','악딜','악탱','양조','풍운','운무','화법','냉법','비법','야냥','생냥','격냥','혈죽','부죽','냉죽','고흑','악흑','파흑','신사','수사','암사','무법','잠행','암살'])
        ];
    }
}
