<?php

use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\User::insert([
            'name' => 'John Doe',
            'email' => 'john@doe.com'
        ]);

        \App\User::insert([
            'name' => 'Jane Doe',
            'email' => 'jane@doe.com'
        ]);
    }
}
