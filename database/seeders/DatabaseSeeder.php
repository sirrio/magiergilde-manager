<?php

namespace Database\Seeders;

use App\Models\CharacterClass;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'David',
            'email' => 'home@sirrio.de',
            'password' => Hash::make('test')
        ]);


        $classes = ['barbarian', 'bard', 'cleric', 'druid', 'fighter', 'monk', 'paladin', 'ranger', 'rogue', 'sorcerer', 'warlock', 'wizard', 'artificer', 'blood_hunter'];
        foreach ($classes as $class) {
            CharacterClass::factory()->create([
                'name' => $class
            ]);
        }
    }
}
