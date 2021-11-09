<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Taerande',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
        ]);
        User::factory()->times(19)->create();
    }
}
