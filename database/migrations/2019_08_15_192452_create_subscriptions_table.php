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
        //table for user_subscriptions
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('subscribed_user_id');
            $table->uuid('user_id');
            $table->integer('notifications_sent')->default(0);
            $table->timestamps();

            //foreign keys
            $table->foreign('subscribed_user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        //table for user_subscriptions
        Schema::create('subscription_updates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('update_user_id');
            $table->uuid('updated_story');
            $table->string('event');    //newStory + newDetail
            $table->timestamps();

            //foreign keys
            $table->foreign('update_user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('updated_story')->references('id')->on('stories')
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
        Schema::dropIfExists('user_subscriptions');
        Schema::dropIfExists('subscription_updates');
    }
}
