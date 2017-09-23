<?php

use Illuminate\Database\Seeder;

class DistrictTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('districts')->insert([
            ['district' => 'Hoa Khanh'],
            ['district' => 'Lien Chieu'],
            ['district' => 'Cam Le']
        ]);
    }
}
