<?php

use Illuminate\Database\Seeder;

class SubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([['subject' => 'Male'], ['subject' => 'Female'], ['subject' => 'All']]);
    }
}
