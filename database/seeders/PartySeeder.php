<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Character;
use App\Models\Party;
use Illuminate\Database\Seeder;

class PartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Party::create([
        //     'user_id' => 1,
        //     'game_id' => 1,
        //     'title' => 'Hello World',
        //     'description' => '실바나스 직 가실 분 모십니다.',
        //     'dungeon' => '지배의 성소',
        //     'difficulty' => 'mythic',
        //     'goal' => '10',
        //     'recruit' => 'druid-balance'
        // ]);

        Party::factory()->times(40)->create()
        ->each(function ($party){

            $user_id = $party->user_id;

            $randCharacter = Character::where('user_id','=',$user_id)->inRandomOrder()->first();

            if(!empty($randCharacter)){
            $party->characters()->where('user_id',$user_id)->syncWithoutDetaching([
                $randCharacter->id => ['grade' => 'leader']]);
            };


            $charSet = Character::where('user_id','!=',$user_id)->get('id')->random(rand(2,7));

            foreach($charSet as $char){
                $party->characters()->syncWithoutDetaching([$char->id => ['grade' => 'member']]);
            };
            
            
        });

    }
}