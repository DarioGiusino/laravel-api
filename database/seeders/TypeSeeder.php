<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        // types
        $types = ['Front-end', 'Back-end', 'Full Stack', 'UI/UX', 'Design'];

        foreach ($types as $type) {
            $new_type = new Type();
            $new_type->label = $type;
            $new_type->color = $faker->hexColor();
            $new_type->save();
        }
    }
}
