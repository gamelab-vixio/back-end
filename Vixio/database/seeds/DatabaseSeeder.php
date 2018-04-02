<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Necessary
        $this->call(CategoryTypeSeeder::class);
        $this->call(CategoryGenreSeeder::class);

        //testing
        // $this->call(DocumentationSeeder::class);
        // $this->call(BlogSeeder::class);
    }
}
