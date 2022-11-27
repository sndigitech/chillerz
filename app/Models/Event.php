<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'genre_id',
        'name',
        'artist_name',
        'details',
        's_date_time',
        'e_date_time',
        'place',
        'cover_image',
        'address_of_the_place',
        'direction_of_the_place',
        'banners',
        'featured_image',
        'why_event',
        'terms_conditions', 
        'interested',
        'review_feedback',
        'like_follow',              
        'people_attending',
        'event_pay_type',
        'amount',
        'discount',
        'coupon',
        'status',
    ];

    protected $dates = ['deleted_at'];

    public function eventType(){
        return $this->belongsTo(EventType::class, 'eventtype_id', 'id');
    }
}
