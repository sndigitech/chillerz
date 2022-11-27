<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use App\Models\VerifyUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'about',
        'email',
        'mobile',
        'password',
        'address',
        'city',
        'country', 
        'image',      
        'otp',       
        'isVerified',       
        'api_token',
        'user_type',
        'source',
        'follower_count',
        'liked_event_count',
        'liked_artist_count',
        'tags',
        'status',
        'prefrences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',                   
    ];    

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }   

    public function verifyUser()
    {
        return $this->hasOne(VerifyUser::class);
    }    

    public function event(){
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function artist(){
        return $this->belongsTo(Artist::class, 'artist_id', 'id');
    }    

    
    public function place(){
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }

     // Check whether user provided email address exist into the user table or not
    function isEmailExist($email){
        $res = DB::table('users')
                     ->where('email', $email)
                     ->first();
        return $res;
    }

    // Check whether user provided mobile address exist into the user table or not
    public function isMobileExist($mobile){
        $res = DB::table('users')
                     ->where('mobile', $mobile)
                     ->first();
        return $res;
    }

    // Getting last inserted user id from user table
    public function getLastInsertedUserId(){               
        $res = DB::table('users')->select('id')->orderBy('created_at', 'desc')->first();
        return $res;        
    }
}    

