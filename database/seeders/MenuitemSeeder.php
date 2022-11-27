<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuitemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menuitems')->insert([
            ['category_id' => 1, 'brand' => 'Whishky 1', 'price' => '20000', 'uploaded_brand_image' => 'uploaded/image/whishky1.jpg'],
            ['category_id' => 2, 'brand' => 'Whishky 2', 'price' => '40000', 'uploaded_brand_image' => 'uploaded/image/whishky2.jpg'],
            ['category_id' => 3, 'brand' => 'Whishky 3', 'price' => '50000', 'uploaded_brand_image' => 'uploaded/image/whishky3.jpg'],
            ['category_id' => 4, 'brand' => 'Whishky 4', 'price' => '70000', 'uploaded_brand_image' => 'uploaded/image/whishky4.jpg'],
            //['category_id' => 2, 'brand' => 'Whishky2', 'Price' => '30000', 'uploaded_brand_image' => 'uploaded/image/whishky2.jpg'],
            //['category_id' => 3, 'brand' => 'Whishky3', 'Price' => '40000', 'uploaded_brand_image' => 'uploaded/image/whishky3.jpg'],
           // ['category_id' => 4, 'brand' => 'Whishky4', 'Price' => '50000', 'uploaded_brand_image' => 'uploaded/image/whishky4.jpg']        
            
        ]);
    }
}
