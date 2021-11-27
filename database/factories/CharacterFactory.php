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
                return rand(1,40);
            },
            'game_id' => Game::where('name','World_Of_Warcraft')->first()->id,
            'name' => $this->faker->name(),
            'spec' => $this->faker->randomElement(
                ['deathknight-blood','deathknight-frost','deathknight-unholy','deathknight-all','demonhunter-all','demonhunter-havoc','demonhunter-vengeance','druid-all','druid-balance','druid-feral','druid-guardian','druid-restoration','hunter-all','hunter-beastmastery','hunter-markmanship','hunter-survival','mage-all','mage-fire','mage-frost','mage-arcane','monk-all','monk-brewmaster','monk-windwalker','monk-mistweaver','paladin-all','paladin-holy','paladin-protection','paladin-retribution','priest-all','priest-discipline','priest-holy','priest-shadow','rogue-all','rogue-assasination','rogue-subtlety','rouge-outlaw','shaman-all','shaman-elemental','shaman-enhancement','shaman-restoration','warlock-all','warlock-affliction','warlock-demonology','warlock-destruction','warrior-all','warrior-protection','warrior-fury'
                ])
        ];
    }
}
