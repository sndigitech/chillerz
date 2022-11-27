<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            [
            'genre_id'=>2,
            'name'=>'Chillerz Party',
            'artist_name'=>'Deepak',
            's_date_time'=>'2019-07-06 18:53:21',
            'e_date_time' =>'2019-07-06 18:53:21',
            'place'=>'Radison Blue',
            'details'=>'First event',
            'why_event'=>'Good#Verygood#world class event',
            'terms_conditions'=>'Good#Verygood#world class event',
            'cover_image'=>'upload/event/cover_image.jpg',
            'address_of_the_place' => 'xyz',
            'direction_of_the_place'=>'xyz',
            'banners'=>'upload/event/banners.jpg',
            'featured_image'=>'upload/event/featured_image.jpg',
            'interested'=>1,
            'review_feedback'=>1,
            'like_follow'=>0,
            'people_attending'=>'who is attending event',
            'event_pay_type'=>1, // 1 for free and 2 for Paid
            'amount'=>20000,
            'discount'=>1000,
            'coupon'=>'ABC100',
            'status'=>2], 
            [
                'genre_id'=>3,
                'name'=>'Chillerz dance Party',
                'artist_name'=>'Deepak',
                's_date_time'=>'2019-07-06 18:53:21',
                'e_date_time' =>'2019-07-06 18:53:21',
                'place'=>'Radison Blue',
                'details'=>'First event',
                'why_event'=>'Good#Verygood#world class event',
                'terms_conditions'=>'Good#Verygood#world class event',
                'cover_image'=>'upload/event/cover_image.jpg',
                'address_of_the_place' => 'xyz',
                'direction_of_the_place'=>'xyz',
                'banners'=>'upload/event/banners.jpg',
                'featured_image'=>'upload/event/featured_image.jpg',
                'interested'=>1,
                'review_feedback'=>0,
                'like_follow'=>0,
                'people_attending'=>'who is attending event',
                'event_pay_type'=>1, // 1 for free and 2 for Paid
                'amount'=>20000,
                'discount'=>1000,
                'coupon'=>'ABC100',
                'status'=>2,             
            ]                    
        ]);
    }
}
