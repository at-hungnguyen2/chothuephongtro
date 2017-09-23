<?php

use Illuminate\Database\Seeder;

class CostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('costs')->insert([
            ['cost' => '300k - 500k'],
            ['cost' => '500k - 700k'],
            ['cost' => '700k - 900k'],
            ['cost' => '>900k']
        ]);
    }
}
