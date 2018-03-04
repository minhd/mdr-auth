<?php

use Illuminate\Database\Seeder;

class UserRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment() === 'production') {
            exit('Not running on production. ');
        }

        DB::table('roles')->truncate();

        \MinhD\Role::create([
            'id'            => 1,
            'name'          => 'admin',
            'description'   => 'Administrator role'
        ]);

        // users without a role is just a normal user
    }
}
