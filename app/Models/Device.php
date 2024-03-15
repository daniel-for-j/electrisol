<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = "devices"; 


    protected $fillable = [
        'code_name',
        'name',
    ];



    protected $hidden = [
        'kilowatt',
        'duration',
        'created_at',
        'updated_at',
        'user_id',
    ];
}
