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
        
        foreach($charset as $char)
        {
            $newList[] = $char['user_id'];
        }

        $userId = $this->faker->randomElement($newList);


        return [
            'user_id' => $userId,
            'game_id' => Game::where('name','World_Of_Warcraft')->first()->id,
            'title' => $this->faker->sentence(),
            'description'=> $this->faker->paragraphs(2,true),
            'dungeon' => '지배의 성소',
            'difficulty' => $this->faker->randomElement(['normal','heroic','mythic']),
            'goal' => $this->faker->numberBetween(1,10),
            'recruit' => $this->faker->randomElement(
                ['deathknight-all',
                'deathknight-blood','deathknight-frost','deathknight-unholy',
                
                'demonhunter-all',
                'demonhunter-havoc','demonhunter-vengeance',
                
                'druid-all',
                'druid-balance','druid-feral','druid-guardian','druid-restoration',
                
                'hunter-all',
                'hunter-beastmastery','hunter-markmanship','hunter-survival',
                
                'mage-all',
                'mage-fire','mage-frost','mage-arcane',
                
                'monk-all','monk-brewmaster','monk-windwalker','monk-mistweaver',
                
                'paladin-all',
                'paladin-holy','paladin-protection','paladin-retribution',
                
                'priest-all',
                'priest-discipline','priest-holy','priest-shadow',
                
                'rogue-all',
                'rogue-assasination','rogue-subtlety','rouge-outlaw',
                
                'shaman-all',
                'shaman-elemental','shaman-enhancement','shaman-restoration',
                
                'warlock-all',
                'warlock-affliction','warlock-demonology','warlock-destruction',
                
                'warrior-all',
                'warrior-protection','warrior-fury','warrior-arms'
                ])
        ];
    }
}
