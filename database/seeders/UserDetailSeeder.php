<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        $user_ids = User::pluck('id')->toArray();

        foreach ($user_ids as $user_id) {
            $user_detail = new UserDetail();
            $user_detail->user_id = $user_id;
            $user_detail->first_name = $faker->firstName();
            $user_detail->last_name = $faker->lastName();
            $user_detail->phone = $faker->phoneNumber();
            $user_detail->address = $faker->address();
            $user_detail->date_of_birth = $faker->date();
            $user_detail->save();
        }
    }
}
