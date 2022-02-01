<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document_Create extends Model
{
    use HasFactory;
    use SoftDeletes; 
    protected $fillable = [ 
        'id',
        'document_code',
        'document_title',
        'document_detail', 
        'document_type', 
        'document_status', 
        'sender_id', 
        'expiration_date',
    ];  
}
    
