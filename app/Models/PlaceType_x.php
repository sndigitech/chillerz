<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaceType_x extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [     
        'name'      
    ];
    protected $dates = ['deleted_at'];

    public function vendor(){
        return $this->hasOne(Vendor::class);
    }
    
    public function place(){
        return $this->hasOne(Place::class);
    }     
    
}
