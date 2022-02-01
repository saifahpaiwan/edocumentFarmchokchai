<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class document_receiver extends Model
{
    use HasFactory;
    use SoftDeletes; 
    protected $fillable = [ 
        'id',
        'document_id', 
        'receiver_id', 
        'signing_rights', 
        'passwrod_is', 
        'passwrod',  
        'signing_position',
        'area_size', 
        'status_approve', 
    ]; 
}
