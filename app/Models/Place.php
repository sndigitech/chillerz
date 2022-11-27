<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'placetype_id',       
        'title',
        'description',
        'location',      
        'logo', // gallary --> logo / photo         
        'photo',
        'video',       
        'start_time',
        'end_time',        
    ];

    public function placeType(){
        return $this->belongsTo(PlaceType::class, 'placetype_id', 'id');
    }

}
