<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorService extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vid', // vendor id
        'eid', // event id
        'booking_name',
        'description',
        'image',
        'payment_type',
        'payment',
        'payment_refund'        
    ];
}
