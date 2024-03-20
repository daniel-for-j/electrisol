<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    use HasFactory;

    protected $table = 'user_devices';

    protected $hidden = [
        'updated_at',
        'user_id',
        'created_at'
    ];

    protected $fillable = [
        'name',
        'kilowatt',
        'duration',
        'user_id',
        'code_name'
    ];
}

