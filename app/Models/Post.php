<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable = [
        'category_id', 'user_id',
    'img','img2','img3','img4','img5', 'location', 'title', 'type', 
    'product_condition', 'description', 'price',
     'negotiable', 'phone_no', 'alt_phone_no', 
     'promo_id'];
     protected $hidden = [
        'updated_at',
        'created_at'
     ];
}
