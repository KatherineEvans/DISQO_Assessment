<?php

namespace Database\Seeders\Data;

use App\Models\User;
use App\Models\Note;
use Illuminate\Database\Seeder;

class PrimarySeeder extends Seeder
{
    /**
     * Run the database seeds. 
     * 
     * @return void
     */

    public function run()
    {
        $exampleUsers = collect([
            ['first_name' => 'Steve', 'last_name' => 'Rodgers', 'email' => 'srogers@marvel.avengers'],
            ['first_name' => 'Bucky', 'last_name' => 'Barnes', 'email' => 'bbarnes@marvel.avengers'],
            ['first_name' => 'Tony', 'last_name' => 'Stark', 'email' => 'tstark@marvel.avengers'],
            ['first_name' => 'Bruce', 'last_name' => 'Banner', 'email' => 'bbanner@marvel.avengers'],
        ]);

        $exampleUsers->each(function ($exampleUser) {
            
            $user = User::factory()->create([
                'first_name' => $exampleUser['first_name'],
                'last_name' => $exampleUser['last_name'],
                'email' => $exampleUser['email'],
            ]);

            $note = Note::factory()->count(3)->create([
                'user_id' => $user->id,
            ]);

        });
    }
}