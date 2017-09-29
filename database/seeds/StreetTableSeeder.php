<?php

use Illuminate\Database\Seeder;

class StreetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('streets')->insert([
            ['street' => 'An Hoa 1', 'district_id' => 1],
            ['street' => 'An Hoa 2', 'district_id' => 1],
            ['street' => 'An Hoa 3', 'district_id' => 1],
            ['street' => 'An Hoa 4', 'district_id' => 1],
            ['street' => 'An Hoa 5', 'district_id' => 1],
            ['street' => 'An Hoa 6', 'district_id' => 1],
            ['street' => 'Bau Tram', 'district_id' => 1],
            ['street' => 'Binh Hoa', 'district_id' => 1],
            ['street' => 'Dang Van Ngu', 'district_id' => 1],
            ['street' => 'Dang Xuan Bang', 'district_id' => 1],
            ['street' => 'Do Dang Tuyen', 'district_id' => 1],
            ['street' => 'Do Thuc Tinh', 'district_id' => 1],
            ['street' => 'Doi Can', 'district_id' => 1],
            ['street' => 'Doi Trung', 'district_id' => 1],
            ['street' => 'Ha Huy Giap', 'district_id' => 1],
            ['street' => 'Hoa My', 'district_id' => 1],
            ['street' => 'Ngo Nhan Tinh', 'district_id' => 1]
        ]);
    }
}
