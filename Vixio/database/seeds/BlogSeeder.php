<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Blog');
        for($i=0; $i < 6; $i++){
            DB::table('blogs')->insert([
                'title' => $faker->sentence,
                'content' => implode($faker->paragraphs(5)),
                'status' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
            for($j = 0; $j < rand(0,10); $j++){
                DB::table('blog_comments')->insert([
                    'blog_id' => $i+1,
                    'user_id' => rand(1,3),
                    'comment' => implode($faker->paragraphs(1)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }
        }
    }
}
