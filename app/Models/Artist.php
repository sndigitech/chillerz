<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artist extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'artisttype_id',
        'name',
        'email',
        'contact_number',
        'about',
        'gender',
        'photo',
        'cover_image',
        'featured_image',
        'city_id',
        'country_id',               
        'website',
        'social_platform',
        'followers_count',
        'profile_sharing_counts',
        'status',
    ];

    protected $dates = ['deleted_at'];

    // public function artistType(){
    //     return $this->belongsTo(ArtistType::class, 'artisttype_id', 'id');
    // }
}
