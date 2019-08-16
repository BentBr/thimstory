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
        //table for stories
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->uuid('storyId');
            $table->uuid('userId');
            $table->boolean('update')->default(0);
            $table->timestamps();

            //foreign keys
            $table->foreign('storyId')->references('id')->on('stories')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('userId')->references('id')->on('users')
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
        Schema::dropIfExists('subscriptions');
    }
}
