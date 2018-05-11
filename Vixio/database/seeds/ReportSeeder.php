<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker::create('App\UserReport');

        for($i = 0; $i < 20; $i++){
        	$reportedID = rand(1,1000);
	    	$reporterID = rand(1,1000);
	    	$storyID = rand(1,500);
	    	$commentType = rand(0,1);
	    	$year = rand(2007, 2017);
	        $month = rand(1, 12);
	        $day = rand(1, 28);
	        $date = \Carbon\Carbon::create($year,$month ,$day , 0, 0, 0);

        	DB::table('user_reports')->insert([
        		'user_id' => $reportedID,
        		'reporter_user_id' => $reporterID,
        		'reason' => $faker->sentence,
        		'comment_type' => $commentType,
        		'created_at' => $date->format('Y-m-d H:i:s'),
                'updated_at' => $date->format('Y-m-d H:i:s'),
    	 	]);

    	 	DB::table('story_reports')->insert([
        		'story_id' => $storyID,
        		'reporter_user_id' => $reporterID,
        		'reason' => $faker->sentence,
        		'created_at' => $date->format('Y-m-d H:i:s'),
                'updated_at' => $date->format('Y-m-d H:i:s'),
    	 	]);
        }
    }
}
