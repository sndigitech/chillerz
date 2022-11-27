<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
    use HasFactory;

    //protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 
        'token',
        'otp'    
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',        
       // 'password',
        //'remember_token',
        //'otp',
       // 'api_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
