<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        $technologies = ['HTML', 'CSS', 'JavaScript', 'Vue.js', 'SASS', 'SQL', 'PHP', 'Laravel'];

        foreach ($technologies as $technology) {
            $new_tech = new Technology();
            $new_tech->label = $technology;
            $new_tech->color = $faker->hexColor();
            $new_tech->save();
        }
    }
}
