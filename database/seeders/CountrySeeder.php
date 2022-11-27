<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            ['country_name' => 'India'],
            ['country_name' => 'UK'],
            ['country_name' => 'US'],
            ['country_name' => 'Nepal'],
            ['country_name' => 'Xyz'],
            
        ]);
    }
}
