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
            'name' => 'World Of Warcraft',
            'genre' => 'MMORPG',
        ]);
        Game::create([
            'name' => 'Lost Ark',
            'genre' => 'MMORPG',
        ]);
        Game::create([
            'name' => 'League Of Legends',
            'genre' => 'AOS',
        ]);
    }
}
