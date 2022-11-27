<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;     

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [       
        'name',
        'slug',
    ];

    protected $dates = ['deleted_at'];

    public function menuItem(){
        return $this->belongsTo(MenuItem::class);
    }

    /*
    public function subcategory()
    {
        return $this->hasMany(Category::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }*/
}
