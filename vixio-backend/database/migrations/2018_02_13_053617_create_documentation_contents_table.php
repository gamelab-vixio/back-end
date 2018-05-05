<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentationContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentation_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subtitle_id')->unsigned();
            $table->foreign('subtitle_id')->references('id')->on('documentation_subtitles')->onDelete('cascade');
            $table->string('header');
            $table->mediumtext('content');
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
        Schema::dropIfExists('documentation_contents');
    }
}
