<?php

namespace App\Http\Controllers\MarketPlace;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function postAd(Request $request){
      

        $postValidator = $request->validate([
            'category_id'=>'required',
            'img'=>'required|image|mimes:jpg,png,jpeg,gif,svg',
            'img2'=>'required|image|mimes:jpg,png,jpeg,gif,svg',
            'img3'=>'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'img4'=>'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'img5'=>'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'location'=>'required',
            'title'=>'required',
            'type'=>'required',
            'product_condition'=>'required',
            'description'=>'required',
            'price'=> 'required',
            'negotiable'=>'required|bool', 
            'phone_no'=>'required',
            'alt_phone_no'=>'required',
            'promo_id'=>'required'
        ]);

        // image upload
        $path = $request->file('img')->store('images');
        $path2 = $request->file('img2')->store('images');
        $path3 = null;
        $path4 = null;
        $path5 = null;

        if($request->file('img3')){
             $path3 = $request->file('img3')->store('images');

        }else if($request->file('img4')){
            $path4 = $request->file('img4')->store('images');

        }else if($request->file('img5')){
            $path5 = $request->file('img5')->store('images');

        }

        // return $postValidator;

        //Acessing image by path
        // 'path'=>Storage::path($img->img) 


      $userId = $request->user()->id;
            $post = Post::create([
                'category_id'=>$postValidator['category_id'],
                'user_id'=> $userId,
                'img'=>$path,
                'img2'=>$path2,
                'img3'=>$path3,
                'img4'=>$path4,
                'img5'=>$path5,
                'location'=>$postValidator['location'],
                'title'=>$postValidator['title'],
                'type'=>$postValidator['type'],
                'product_condition'=>$postValidator['product_condition'],
                'description'=>$postValidator['description'],
                'price'=> $postValidator['price'],
                'negotiable'=> $postValidator['negotiable'], 
                'phone_no'=>$postValidator['phone_no'],
                'alt_phone_no'=>$postValidator['alt_phone_no'],
                'promo_id'=>$postValidator['promo_id'],
    
            ]);
         

            if($post){
                return [
                    'message'=>'Post Created Successfully'
                ];
            }


     
    }


    public function singlePost(Request $request,$postId){
        $userId = $request->user()->id;

        $singlePost = Post::find($postId);


        if(!$singlePost)
        {
            return [
                'message'=>'There is no such Post.'
            ];
        }

        if($userId == $singlePost->user_id){
            $category = Category::where('id',$singlePost->category_id)->first();
            return [
                'single_post'=> [
                    'category'=>$category->name,
                     'user_id'=>$singlePost->user_id,
                     'img' =>Storage::path($singlePost->img),
                     'img2'=>Storage::path($singlePost->img2),
                     'img3'=>($singlePost->img3 !==  null) ? Storage::path($singlePost->img3): null,
                     'img4'=>(($singlePost->img4 !==  null)) ? Storage::path($singlePost->img4): null,
                     'img5'=>(($singlePost->img5 !==  null)) ? Storage::path($singlePost->img5): null,
                     'location'=>$singlePost->location,
                     'title'=>$singlePost->title,
                     'type'=>$singlePost->type, 
                     'product_condition'=>$singlePost->product_condition,
                     'description'=>$singlePost->description,
                     'price'=>$singlePost->price,
                     'negotiable'=>$singlePost->negotiable, 
                     'phone_no'=>$singlePost->phone_no, 
                     'alt_phone_no'=>$singlePost->alt_phone_no, 
                ]
            ];
        }
        else {
            return [
                'message'=>'Post does not belong to user'
            ];
        }

    }


    public function myPosts(Request $request){
        $myPosts = Post::where('user_id',$request->user()->id)->get();

        return [
            'message'=>'Your Posts',
            'my_posts'=> $myPosts
        ];
    }
}
