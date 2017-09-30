<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'name' => 'Administrator',
        	'email' => 'admin@example.com',
        	'password' => bcrypt('123456'),
        	'is_admin' => 1
        ]);
    }
}