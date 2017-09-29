<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CostTableSeeder::class);
        $this->call(DistrictTableSeeder::class);
        $this->call(PostTableSeeder::class);
        $this->call(PostTypeTableSeeder::class);
        $this->call(SubjectTableSeeder::class);
        $this->call(StreetTableSeeder::class);
    }
}
