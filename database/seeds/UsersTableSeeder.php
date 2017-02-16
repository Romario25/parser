<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@site.loc',
            'password' => bcrypt('secret'),
            'username' => 'admin',
            'role' => \App\User::ADMIN,
            'status' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'customer',
            'email' => 'customer@site.loc',
            'password' => bcrypt('secret'),
            'username' => 'customer',
            'role' => \App\User::CUSTOMER,
            'status' => 1
        ]);
    }
}
