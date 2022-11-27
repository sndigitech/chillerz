<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organizer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [       
        'name',        
        'about',
        'email',        
        'service_names',
        'about_service',
        'contact_person_name',
        'contact_person_id',
        'status',
        'cover_photo',
        'city',
        'country',        
        'website',
        'social_platforms',
    ];

    protected $dates = ['deleted_at'];

}
