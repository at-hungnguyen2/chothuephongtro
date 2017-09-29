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
            ['district' => 'Cẩm Lệ'],
            ['district' => 'Thanh Khê'],
            ['district' => 'Sơn Trà'],
            ['district' => 'Liên Chiểu'],
            ['district' => 'Ngũ Hành Sơn'],
            ['district' => 'Hải Châu']
        ]);
    }
}
