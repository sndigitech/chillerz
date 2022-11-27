<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlacetypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('placetypes')->insert([
            ['name' => 'Hotel'],
            ['name' => 'Bars'],
            ['name' => 'Restaurant'],
            ['name' => 'Nightclub'],
            ['name' => 'xyz'],
        ]);
    }
}
