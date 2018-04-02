<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title');
            $table->string('image_url')->nullable()->default(null);
            $table->longText('description');
            $table->longtext('content')->nullable()->default(null);
            $table->longtext('inkle')->nullable()->default(null);
            $table->boolean('publish')->default(0);
            $table->timestamp('year_of_release')->nullable()->default(null);
            $table->integer('played')->default(0);
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stories');
    }
}
