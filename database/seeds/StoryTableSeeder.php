<?php

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class StoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws
     */
    public function run()
    {
        DB::table('stories')->insert([
            'id'        => '12c6290b-94bb-400e-900e-1a4b34e8b8a5',
            'user_id'   => '04c6290b-94bb-400e-900e-1a4b34e34565',
            'name'      => 'Bent Story number #1',
            'url_name'  => rawurlencode('Bent Story number #1'),
            'views'     => '13',
            'follower'  => '0',
        ]);

        DB::table('story_details')->insert([
            'id'            => Uuid::uuid4(),
            'story_counter' => 0,
            'stories_id'    => '12c6290b-94bb-400e-900e-1a4b34e8b8a5',
            'views'         => '133778',
            'mime_type'     => 'image/jpeg'
        ]);

        DB::table('user_subscriptions')->insert([
            'id'                    => Uuid::uuid4(),
            'subscribed_user_id'    => '04c6290b-94bb-400e-900e-1a4b34e8b8a5',
            'user_id'               => '04c6290b-94bb-400e-900e-1a4b34e34565',
        ]);
    }
}
