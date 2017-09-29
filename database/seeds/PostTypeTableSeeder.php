<?php

use Illuminate\Database\Seeder;

class PostTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_types')->insert([
            ['type' => 'Phòng Trọ, Nhà Trọ'],
            ['type' => 'Nhà Nguyên Căn'],
            ['type' => 'Cho Thue Căn Hộ'],
            ['type' => 'Tìm Bạn Ở Ghép'],
            ['type' => 'Cho Thuê Mặt Bằng']
        ]);
    }
}
