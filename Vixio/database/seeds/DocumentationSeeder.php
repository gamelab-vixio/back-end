<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paragraph = 1;
        $faker = Faker::create('App\DocumentationTitle');
        for($i = 1; $i <= 5; $i++){
            DB::table('documentation_titles')->insert([
                'title' => $faker->sentence,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
            for($j = 1; $j <= rand(3,5); $j++){
                DB::table('documentation_subtitles')->insert([
                    'title_id' => $i,
                    'subtitle' => $faker->sentence,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
                for($k = 1; $k <= rand(3,6); $k++){
                    DB::table('documentation_contents')->insert([
                        'subtitle_id' => $paragraph,
                        'header' => $faker->sentence,
                        'content' => implode($faker->paragraphs(rand(1,3))),
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
                }
                $paragraph++;
            }
        }
    }
}
