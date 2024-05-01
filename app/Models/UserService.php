<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserService extends Model
{
    use HasFactory;

    protected $table = 'user_service';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'user_id',
        'category_id',
        'description',
        'profession',
        'phone'
    ];

}
