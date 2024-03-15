<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    use HasFactory;
    protected $table = "reports"; 
    protected $fillable = [
        'report_desc',
        'location',
        'affected_disco',
        'company_name',
        'phone_no',
        'email',
        'user_id'
    ];

    protected $hidden = [
        'updated_at',
        'user_id',
    ];
    


}
