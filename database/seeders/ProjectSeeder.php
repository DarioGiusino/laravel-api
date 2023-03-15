<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        //types count selected by id, retrieved for all the values in the id column(pluck), and transformed in array
        $types_count = Type::select('id')->pluck('id')->toArray();

        $technologies = Technology::select('id')->pluck('id')->toArray();

        for ($i = 0; $i < 8; $i++) {
            // create new istance
            $project = new Project();

            //type_id foreign key
            $project->type_id = Arr::random($types_count);
            // fill cols with faker utils
            $project->title = $faker->text(20);
            $project->description = $faker->paragraphs(10, true);
            // $project->image = $faker->imageUrl(200, 200);
            $project->repo_link = $faker->url(1);
            $project->is_published = $faker->boolean();

            // fill row
            $project->save();

            // add random technologies
            $random_ids = [];

            foreach ($technologies as $technology) {
                if ($faker->boolean()) $random_ids[] = $technology;
            }

            $project->technologies()->attach($random_ids);
        }
    }
}
