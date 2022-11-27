<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [      
        'placetype_id',
        'name',
        'description',
        'email', 
        'password',      
        'contact_number',      
        'logo',
        'photos',
        'cover_image',
        'featured_image',
        'videos',
        'address',
        'city_id',
        'country_id',           
        'website',        
        'lat_tude',
        'long_tude',
        'start_time',
        'end_time',
        'status',
        'tags',
    ];

    protected $dates = ['deleted_at'];

    public function placeType(){
        return $this->belongsTo(PlaceType::class, 'place_type_id', 'id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',                  
    ];

}
