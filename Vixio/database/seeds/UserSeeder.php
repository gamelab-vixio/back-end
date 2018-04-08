<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        static $password;

        $faker = Faker::create('App\User');

        for($i = 0; $i < 1000; $i++){
        	$firstName = $faker->firstName;
        	$lastName = $faker->lastname;
        	$username = $lastName.'.'.$firstName;
            DB::table('users')->insert([
                'name' => $firstName.' '.$lastName,
                'email' => $username.'@'.$faker->safeEmailDomain,
                'password' => $password ?: $password = bcrypt('123123'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
