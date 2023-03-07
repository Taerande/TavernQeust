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

        foreach ($partySet as $party) {
            $newList[] = $party['id'];
        }
        $dungeon =
            [
                [
                    "id" => "df_s1_ruby_life_pools",
                    "type" => "keystone"
                ],
                [
                    "id" => "df_s1_algeth'ar_academy",
                    "type" => "keystone"
                ],
                [
                    "id" => "df_s1_the_nokhud_offensive",
                    "type" => "keystone"
                ],
                [
                    "id" => "df_s1_the_azure_vault",
                    "type" => "keystone"
                ],
                [
                    "id" => "df_s1_court_of_stars",
                    "type" => "keystone"
                ],
                [
                    "id" => "df_s1_halls_of_valor",
                    "type" => "keystone"
                ],
                [
                    "id" => "df_s1_shadowmoon_burial_grounds",
                    "type" => "keystone"
                ],
                [
                    "id" => "df_s1_temple_of_the_jade_serpent",
                    "type" => "keystone"
                ],
                [
                    "id" => "df_vault_of_the_incarnates",
                    "type" => "raid"
                ],
                [
                    "id" => "df_ruby_life_pools",
                    "type" => "dungeon"
                ],
                [
                    "id" => "df_brackenhide_hollow",
                    "type" => "dungeon"
                ],
                [
                    "id" => "df_the_nokhud_offensive",
                    "type" => "dungeon"
                ],
                [
                    "id" => "df_uldaman:_legacy_of_tyr",
                    "type" => "dungeon"
                ],
                [
                    "id" => "df_neltharus",
                    "type" => "dungeon"
                ],
                [
                    "id" => "df_the_azure_vault",
                    "type" => "dungeon"
                ],
                [
                    "id" => "df_halls_of_infusion",
                    "type" => "dungeon"
                ],
                [
                    "id" => "df_algeth'ar_academy",
                    "type" => "dungeon"
                ],
            ];
        $random_key = array_rand($dungeon);
        $random_value = $dungeon[$random_key];
        $difficulty = $random_value['type'] === 'keystone' ? $this->faker->randomElement(['keystone', 'mythic', 'heroic', 'normal']) : $this->faker->randomElement(['mythic', 'heroic', 'normal']);
        $partyId = $this->faker->randomElement($newList);
        $recruits = $this->faker->randomElements(
            [
                'deathknight-all',
                'deathknight-blood', 'deathknight-frost', 'deathknight-unholy',

                'demonhunter-all',
                'demonhunter-havoc', 'demonhunter-vengeance',

                'druid-all',
                'druid-balance', 'druid-feral', 'druid-guardian', 'druid-restoration',

                'ranger-all',
                'ranger-beastmastery', 'ranger-markmanship', 'ranger-survival',

                'mage-all',
                'mage-fire', 'mage-frost', 'mage-arcane',

                'monk-all', 'monk-brewmaster', 'monk-windwalker', 'monk-mistweaver',

                'paladin-all',
                'paladin-holy', 'paladin-protection', 'paladin-retribution',

                'priest-all',
                'priest-discipline', 'priest-holy', 'priest-shadow',

                'rogue-all',
                'rogue-assasination', 'rogue-subtlety', 'rogue-outlaw',

                'shaman-all',
                'shaman-elemental', 'shaman-enhancement', 'shaman-restoration',

                'warlock-all',
                'warlock-affliction', 'warlock-demonology', 'warlock-destruction',

                'warrior-all',
                'warrior-protection', 'warrior-fury', 'warrior-arms'
            ],
            rand(1, 5)
        );



        return [
            'party_id' => $partyId,
            'title' => $this->faker->sentence(),
            'start' => $currentDateTime->format('Y-m-d H:m'),
            'end' => $intervalDateTime->format('Y-m-d H:m'),
            'description' => $this->faker->paragraphs(2, true),
            'dungeon' => $random_value['id'],
            'reward' => $this->faker->numberBetween(10, 99) * 100,
            'difficulty' => $difficulty,
            'goal' => $this->faker->numberBetween(1, 10),
            'recruit' => implode(',', $recruits),
        ];
    }
}
