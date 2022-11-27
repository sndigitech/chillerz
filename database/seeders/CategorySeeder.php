<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Vodka', 'slug' => 'vodka'],
            ['name' => 'Whiskey', 'slug' => 'whiskey'],
            ['name' => 'Gin', 'slug' => 'gin'],
            ['name' => 'Rum', 'slug' => 'rum'],
            ['name' => 'xyz Rum', 'slug' => 'xyz rum'],
        ]);
        
    }
}
