<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('artists')->insert([
            'artisttype_id'=>1,
            "name" => 'Deepak',
            "email"=>'sndigitech.deepak@gmail.com',
            "contact_number"=>8800380273,
            'about'=>'Deepak .........',
            "gender" => 'male',
            "photo"=>'upload/artist/photo/artist.jpg',
            "cover_image" => 'upload/artist/cover_image/artist.jpg',
            "featured_image" => "upload/artist/featured_image/artist.jpg",
            "city_id"=>2,
            "country_id" => 1,
            "website"=>'sndigitech.com',
            "social_platform"=>'skype.com/deepak',
            'followers_count'=>100,
            'profile_sharing_counts'=>10,
            'status'=>2           
        ]);
        
    }
}
