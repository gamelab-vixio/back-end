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
        for($i=0; $i < 10; $i++){
            DB::table('stories')->insert([
                'user_id' => rand(1,3),
                'title' => $faker->sentence,
                'description' => implode($faker->paragraphs(2)),
                'content' => implode($faker->paragraphs(1)),
                'inkle' => "﻿{\"inkVersion\":17,\"root\":[\"^whatssssup\",\"\\n\",\"^yey!\",\"\\n\",\"done\",{\"#f\":3}],\"listDefs\":{}}",
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
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
        }
    }
}
