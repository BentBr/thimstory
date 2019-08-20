<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //table for storySubscriptions
        Schema::create('story_subscriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('stories_id');
            $table->uuid('user_id');
            $table->boolean('update')->default(0);
            $table->timestamps();

            //foreign keys
            $table->foreign('stories_id')->references('id')->on('stories')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        //table for stories
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('subscribed_user_id');
            $table->uuid('user_id');
            $table->boolean('update')->default(0);
            $table->timestamps();

            //foreign keys
            $table->foreign('subscribed_user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('story_subscriptions');
        Schema::dropIfExists('user_subscriptions');
    }
}
