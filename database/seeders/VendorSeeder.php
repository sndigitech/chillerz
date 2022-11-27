<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vendors')->insert([
            'placetype_id'=>1,
            'name'=>'Deepak',
            'description'=>'provides all types cafe party',
            'email'=>'vendordeepak@yopmail.com', 
            'password' => Hash::make('password'),      
            'contact_number' => '8800380273',      
            'logo' => 'upload/vendor/logo.png',
            'photos' => 'upload/vendor/photos/photo.png#',
            'cover_image' => 'upload/vendor/cover_image/cover_image.png',
            'featured_image' => 'upload/vendor/featured_image/featured_image.jpg',
            'videos' =>'upload/vendor/videos/videos.jpg',
            'address' =>'Sector 44, Noida',
            'city_id' => 2,
            'country_id' => 1,           
            'website' =>'sndigitech.com',        
            'lat_tude' => null,
            'long_tude' => null,
            'start_time' => null,
            'end_time' => null,
            'status' => 1 ,
            'tags' =>"abc#cde#def#xyz#pqr",
        ]);
    }
}
