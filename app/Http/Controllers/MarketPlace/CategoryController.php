<?php

namespace App\Http\Controllers\MarketPlace;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function postCategories(Request $request){
        $postCategories = Category::where('tag','post')->get();

        return [
            'success'=> true,
            'message'=> 'Post Categories',
            'categories'=> $postCategories
        ];
    }

    public function professionCategories(Request $request){
        $professionCategories = Category::where('tag','profession')->get();


        return response()->json([
            'success'=> true,
            'message'=> 'categories',
            'categories'=> $professionCategories
        ],200);

        

    }
}
