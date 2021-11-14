<?php

namespace Database\Factories;

use App\Models\Character;
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
        foreach($charset as $char)
        {
            $newList[] = $char['user_id'];
        }
        $userId = $this->faker->randomElement($newList);

        $currentDateTime = $this->faker->dateTimeBetween('-1 week', '+1 week');

        $intervalDateTime = $this->faker->dateTimeBetween('+1 week', '+3 weeks');

        return [
            'user_id' => $userId,
            'game_id' => '1',
            'title' => $this->faker->sentence(),
            'description'=> $this->faker->paragraphs(2,true),
            'dungeon' => '지배의 성소',
            'difficulty' => $this->faker->randomElement(['일반','영웅','신화']),
            'goal' => $this->faker->numberBetween(1,10),
            'datetimeStart' => $currentDateTime,
            'datetimeEnd' => $intervalDateTime,
            'recruit' => $this->faker->randomElement(
                ['수드','조드','야드','회드','정술','복술','고술','신기','징기','보기','분전','무전','전탱','악딜','악탱','양조','풍운','운무','화법','냉법','비법','야냥','생냥','격냥','혈죽','부죽','냉죽','고흑','악흑','파흑','신사','수사','암사','무법','잠행','암살'])
        ];
    }
}
