<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            ['name' => 'Menu1'],
            ['name' => 'Menu2'],
            ['name' => 'Menu3'],
            ['name' => 'Menu4'],
            ['name' => 'Menu5'],
        ]);
    }
}
