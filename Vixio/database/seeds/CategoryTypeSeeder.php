<?php

use Illuminate\Database\Seeder;

class CategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('category_types')->insert([
            'genre_id' => '2',
            'name' => 'Fiction',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('category_types')->insert([
            'genre_id' => '2',
            'name' => 'Comedy',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('category_types')->insert([
            'genre_id' => '2',
            'name' => 'Drama',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('category_types')->insert([
            'genre_id' => '2',
            'name' => 'Horror',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('category_types')->insert([
            'genre_id' => '2',
            'name' => 'Non-fiction',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('category_types')->insert([
            'genre_id' => '2',
            'name' => 'Realistic',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('category_types')->insert([
            'genre_id' => '2',
            'name' => 'Romantic',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        DB::table('category_types')->insert([
            'genre_id' => '2',
            'name' => 'Satire',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        DB::table('category_types')->insert([
            'genre_id' => '2',
            'name' => 'Tragedy',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        DB::table('category_types')->insert([
            'genre_id' => '2',
            'name' => 'Tragicomedy',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        DB::table('category_types')->insert([
            'genre_id' => '2',
            'name' => 'Fantasy',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        DB::table('category_types')->insert([
            'genre_id' => '2',
            'name' => 'Mythology',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);


        DB::table('category_types')->insert([
            'genre_id' => '3',
            'name' => 'Action',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        

        DB::table('category_types')->insert([
            'genre_id' => '3',
            'name' => 'Adventure',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        DB::table('category_types')->insert([
            'genre_id' => '3',
            'name' => 'Role-playing',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        DB::table('category_types')->insert([
            'genre_id' => '3',
            'name' => 'Simulation',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        DB::table('category_types')->insert([
            'genre_id' => '3',
            'name' => 'Strategy',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        DB::table('category_types')->insert([
            'genre_id' => '3',
            'name' => 'Sport',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        DB::table('category_types')->insert([
            'genre_id' => '3',
            'name' => 'Puzzle',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
