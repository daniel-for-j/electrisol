<?php

namespace App\Http\Controllers\MarketPlace;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function categories(Request $request){
        $categories = Category::get();

        return [
            'message'=> 'categories',
            'categories'=> $categories
        ];
    }
}
