<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DoctorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_GB');
        DB::table('doctors')->insert([
            'first_name' => $faker->name,
            'last_name' => $faker->name,
            'email' => $faker->safeEmail,
            'phone_number' => $faker->phoneNumber,
        ]);
    }
}
