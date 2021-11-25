<?php

namespace Database\Seeders;

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
        Party::create([
            'user_id' => 1,
            'game_id' => 1,
            'title' => 'Hello World',
            'description' => '실바나스 직 가실 분 모십니다.',
            'dungeon' => '지배의 성소',
            'difficulty' => 'mythic',
            'goal' => '10',
            'recruit' => 'druid-balance'
        ]);
        Party::factory()->times(25)->create();
    }
}
