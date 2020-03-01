<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('name')->unique();
            $table->string('url_name')->index();
            $table->string('email')->unique();
            $table->bigInteger('views')->default(0);
            $table->timestamp('email_verified_at')->default(now());
            $table->timestamp('new_story_possible_at')->default(now());
            $table->timestamp('new_story_detail_possible_at')->default(now());
            $table->rememberToken()->index();
            $table->string('login_token')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
