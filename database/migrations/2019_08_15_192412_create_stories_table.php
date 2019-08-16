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
        //table for stories
        Schema::create('stories', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('user_id');
            $table->string('name');
            $table->string('url_name');
            $table->integer('views')->default(0);
            $table->integer('follower')->default(0);
            $table->timestamps();
            $table->softDeletes();

            //foreign keys
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        //table for story details
        Schema::create('story_details', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('story_id');
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes();

            //foreign keys
            $table->foreign('story_id')->references('id')->on('stories')
                ->onUpdate('cascade')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('story_details');
        Schema::dropIfExists('stories');
    }
}
