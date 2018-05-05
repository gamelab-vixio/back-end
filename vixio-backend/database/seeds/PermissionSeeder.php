<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'create-blog-post',
            'display_name' => 'Create post',
            'description' => 'User can create blog post',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => 'edit-blog-post',
            'display_name' => 'Edit post',
            'description' => 'User can edit blog post',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete-blog-post',
            'display_name' => 'Delete post',
            'description' => 'User can delete blog post',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => 'read-blog-post',
            'display_name' => 'Read post',
            'description' => 'User can read blog post',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => 'comment-blog-post',
            'display_name' => 'Comment post',
            'description' => 'User can comment blog post',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => 'create-docs',
            'display_name' => 'Create Documentation',
            'description' => 'User can create documentation',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => 'edit-docs',
            'display_name' => 'Edit Documentation',
            'description' => 'User can edit documentation',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete-docs',
            'display_name' => 'Delete Documentation',
            'description' => 'User can delete documentation',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => 'create-story',
            'display_name' => 'Create Story',
            'description' => 'User can create story',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => 'edit-story',
            'display_name' => 'Edit Story',
            'description' => 'User can edit story',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete-story',
            'display_name' => 'delete Story',
            'description' => 'User can delete story',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => 'play-story',
            'display_name' => 'play Story',
            'description' => 'User can play story',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
