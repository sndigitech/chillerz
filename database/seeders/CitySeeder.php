<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            ['city_name' => 'Kanpur'],
            ['city_name' => 'Lucknow'],
            ['city_name' => 'Delhi'],
            ['city_name' => 'Noida'],
            ['city_name' => 'ABC'],
           
            
        ]);
    }
}
