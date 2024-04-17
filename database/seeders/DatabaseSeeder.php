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


    $classes = [
      'Artificer' => '/images/artificer.jpeg',
      'Barbarian' => '/images/barbarian.jpeg',
      'Bard' => '/images/bard.jpeg',
      'Blood Hunter' => '/images/bloodhunter.jpeg',
      'Cleric' => '/images/cleric.jpeg',
      'Druid' => '/images/druid.jpeg',
      'Fighter' => '/images/fighter.jpeg',
      'Monk' => '/images/monk.jpeg',
      'Paladin' => '/images/paladin.jpeg',
      'Ranger' => '/images/ranger.jpeg',
      'Rogue' => '/images/rogue.jpeg',
      'Sorcerer' => '/images/sorcerer.jpeg',
      'Warlock' => '/images/warlock.jpeg',
      'Wizard' => '/images/wizard.jpeg',
      ];
    foreach ($classes as $class => $src) {
      CharacterClass::factory()->create([
        'name' => $class,
        'src' => $src
      ]);
    }
  }
}
