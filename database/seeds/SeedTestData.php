<?php


use Illuminate\Database\Seeder;
use MinhD\User;

class SeedTestData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // we'll have an admin
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@localhost',
            'password' => Hash::make('secret')
        ]);

        // admin has 2 data sources
        $ds1 = \MinhD\Repository\DataSource::create([
            'title' => 'First Data Source',
            'description' => '',
            'user_id' => $admin->id
        ]);

        $ds2 = \MinhD\Repository\DataSource::create([
            'title' => 'Second Data Source',
            'description' => '',
            'user_id' => $admin->id
        ]);

        // john
        $john = User::create([
            'name' => 'John',
            'email' => 'john@site1.com',
            'password' => Hash::make('johndoe')
        ]);

        // john has 1 data source
        $uni1 = \MinhD\Repository\DataSource::create([
            'title' => 'University of Southern Cross',
            'description' => 'Contact john',
            'user_id' => $john->id
        ]);

        $jane = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@site2.com',
            'password' => Hash::make('janedoe')
        ]);

        // jane has 2 data sources
        $bubblesds = \MinhD\Repository\DataSource::create([
            'title' => 'Bubbles Tech Inc',
            'description' => '',
            'user_id' => $jane->id
        ]);

        $salonTek = \MinhD\Repository\DataSource::create([
            'title' => 'SalonTek tm',
            'description' => '',
            'user_id' => $jane->id
        ]);

    }
}