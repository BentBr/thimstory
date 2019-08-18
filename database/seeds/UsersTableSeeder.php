<?php

use Illuminate\Database\Seeder;
use thimstory\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws
     */
    public function run()
    {
        //default user = Bent
        DB::table('users')->insert([
            'id'        => '04c6290b-94bb-400e-900e-1a4b34e8b8a5',
            'name'      => 'Bent',
            'url_name'  => rawurlencode('Bent'),
            'email'     => 'mail@bent-brueggemann.de',
        ]);

        //#1 testuser
        DB::table('users')->insert([
            'id'        => '04c6290b-94bb-400e-900e-1a4b34e34565',
            'name'      => 'Bent Test1',
            'url_name'  => rawurlencode('Bent Test1'),
            'email'     => 'bent@bent-brueggemann.de',
        ]);

        //creating 50 random user
        factory(User::class, 20)
            ->create();
    }
}
