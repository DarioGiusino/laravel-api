<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        $user = new User();
        $user->name = 'Dario';
        $user->email = 'Drenian_J@live.it';
        $user->password = bcrypt('ciaonedario');
        $user->save();

        for ($i = 0; $i < 4; $i++) {
            $user = new User();
            $user->name = $faker->userName();
            $user->email = $faker->email();
            $user->password = bcrypt('ciaonedario');
            $user->save();
        }
    }
}
