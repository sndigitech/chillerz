<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtisttypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('artisttypes')->insert([
            ['name' => 'Singer'],
            ['name' => 'Musician'],
            ['name' => 'Actor'],
            ['name' => 'Actress'],
            ['name' => 'xyz'],
        ]);
    }
}
