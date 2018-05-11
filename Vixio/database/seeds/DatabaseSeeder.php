<?php

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //Necessary (only once)
        /*$this->call(CategoryTypeSeeder::class);
        $this->call(CategoryGenreSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);*/

        $this->testing();
    }

    public function testing(){
       /* $this->call(DocumentationSeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StorySeeder::class);*/
        $this->call(ReportSeeder::class);
    }
}
