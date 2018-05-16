<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Story');
        $fisherYates = array();
        for($i=0; $i < 500; $i++){
            $year = rand(2007, 2017);
            $month = rand(1, 12);
            $day = rand(1, 28);
            $date = \Carbon\Carbon::create($year,$month ,$day , 0, 0, 0);
            $isPublish = (int) rand(0,1);
            $releaseYear = null;
            $played = rand(0, 50);
            $userID = rand(1,1000);

            if($isPublish) $releaseYear = \Carbon\Carbon::now();

            DB::table('stories')->insert([
                'user_id' => $userID,
                'title' => $faker->sentence,
                'description' => implode($faker->paragraphs(1)),
                'content' => implode($faker->paragraphs(rand(2,5))),
                'inkle' => "﻿{\"inkVersion\":17,\"root\":[\"^whatssssup\",\"\\n\",\"^yey!\",\"\\n\",\"done\",{\"#f\":3}],\"listDefs\":{}}",
                'publish' => $isPublish,
                'year_of_release' => $releaseYear,
                'played' => $played,
                'created_at' => $date->format('Y-m-d H:i:s'),
                'updated_at' => $date->format('Y-m-d H:i:s'),
            ]);

            for($j = 0; $j < $played; $j++){
                DB::table('story_reviews')->insert([
                    'story_id' => $i+1,
                    'user_id' => rand(1,1000),
                    'star' => rand(0, 5),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }

            for($x = 0; $x < 19; $x++){
                $fisherYates[$x] = $x+1;
            }

            for($x = 0; $x < 18; $x++){
                $y = rand($x, 18);
                $temp = $fisherYates[$x];
                $fisherYates[$x] = $fisherYates[$y];
                $fisherYates[$y] = $temp;
            }

            for($j=0; $j< rand(2,5); $j++){
                DB::table('story_categories')->insert([
                    'story_id' => $i+1,
                    'category_type_id' => $fisherYates[$j],
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }

            for($j = 0; $j < rand(0,5); $j++){
                DB::table('story_comments')->insert([
                    'story_id' => $i+1,
                    'user_id' => rand(1,3),
                    'comment' => implode($faker->paragraphs(1)),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }
        }
    }
}
