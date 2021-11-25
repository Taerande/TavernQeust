<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Game::create([
            'name' => 'World_Of_Warcraft',
            'genre' => 'MMORPG',
        ]);
        Game::create([
            'name' => 'Lost_Ark',
            'genre' => 'MMORPG',
        ]);
        Game::create([
            'name' => 'League_Of_Legends',
            'genre' => 'AOS',
        ]);
    }
}
