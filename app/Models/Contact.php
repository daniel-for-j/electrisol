<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contact';

    protected $fillable = [
        'company_name',
        'full_name',
        'message',
        'phone_no',
        'email'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
