<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
 
class order extends Model
{
    use HasFactory;
    use SoftDeletes; 
    protected $fillable = [ 
        'users_id',
        'order_code',
        'sender_fname',
        'sender_lname',
        'sender_email',
        'sender_phone',
        'sender_no',
        'sender_address',
        'sender_parish',
        'sender_district',
        'sender_province',
        'sender_zipcode', 
        'price_total',
        'price_cost',
        'price_delivery',
        'price_discount',
        'net_total', 
        'delivery_form',
        'payment', 
    ];  
}
