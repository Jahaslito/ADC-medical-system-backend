<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReceptionistsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_GB');
        DB::table('receptionists')->insert([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->safeEmail,
            'phone_number' => $faker->phoneNumber,
        ]);
    }
}
