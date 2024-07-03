<?php

namespace App\Http\Controllers\MarketPlace;

use App\Http\Controllers\Controller;
use App\Models\Likes;
use App\Models\Cart;
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
                    'success'=> true,
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


        $basePath = 'https://hoverinsight.com/public/';


        if($userId == $singlePost->user_id){
            $category = Category::where('id',$singlePost->category_id)->first();
            return [
                'success'=> true,
                'single_post'=> [
                    'post_id'=>$singlePost->id,
                    'category'=>$category->name,
                     'user_id'=>$singlePost->user_id,
                     'img' =>$basePath.$singlePost->img,
                     'img2'=>$basePath.$singlePost->img2,
                     'img3'=>($singlePost->img3 !==  null) ? $basePath.$singlePost->img3: null,
                     'img4'=>(($singlePost->img4 !==  null)) ? $basePath.$singlePost->img4: null,
                     'img5'=>(($singlePost->img5 !==  null)) ? $basePath.$singlePost->img5: null,
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
        $posts = Post::where('user_id',$request->user()->id)->get();

        $basePath = 'https://hoverinsight.com/public/';

        $myPosts=[];

        foreach($posts as $singlePost){
            $category = Category::where('id',$singlePost->category_id)->first();
            $post = [
                    'post_id'=>$singlePost->id,
                    'category'=>$category->name,
                     'user_id'=>$singlePost->user_id,
                     'img' =>$basePath.$singlePost->img,
                     'img2'=>$basePath.$singlePost->img2,
                     'img3'=>($singlePost->img3 !==  null) ? $basePath.$singlePost->img3: null,
                     'img4'=>(($singlePost->img4 !==  null)) ? $basePath.$singlePost->img4: null,
                     'img5'=>(($singlePost->img5 !==  null)) ? $basePath.$singlePost->img5: null,
                     'location'=>$singlePost->location,
                     'title'=>$singlePost->title,
                     'type'=>$singlePost->type, 
                     'product_condition'=>$singlePost->product_condition,
                     'description'=>$singlePost->description,
                     'price'=>$singlePost->price,
                     'negotiable'=>$singlePost->negotiable, 
                     'phone_no'=>$singlePost->phone_no, 
                     'alt_phone_no'=>$singlePost->alt_phone_no, 
                ];
                array_push($myPosts,$post);
        }


        return [
            'success'=> true,
            'message'=>'Your Posts',
            'my_posts'=> $myPosts
        ];
    }

    public function allPosts(Request $request){
    
        $categoryPosts = Category::with('posts')->where('tag','post')->get();
        
        // $groupedPosts = $categoryPosts->groupBy(function ($categoryPosts) {
        //     return $categoryPosts->name;
        // });

        $response = $categoryPosts->map(function ($category) {
            return [
                'category' => $category->name,
                'posts' => $category->posts->map(function ($post) {
                          $basePath = 'https://hoverinsight.com/public/';
                    return [
                        'post_id'=>$post->id,
                        // 'category'=>$category->name,
                         'user_id'=>$post->user_id,
                         'img' =>$basePath.$post->img,
                         'img2'=>$basePath.$post->img2,
                         'img3'=>($post->img3 !==  null) ? $basePath.$post->img3: null,
                         'img4'=>(($post->img4 !==  null)) ? $basePath.$post->img4: null,
                         'img5'=>(($post->img5 !==  null)) ? $basePath.$post->img5: null,
                         'location'=>$post->location,
                         'title'=>$post->title,
                         'type'=>$post->type, 
                         'product_condition'=>$post->product_condition,
                         'description'=>$post->description,
                         'price'=>$post->price,
                         'negotiable'=>$post->negotiable, 
                         'phone_no'=>$post->phone_no, 
                         'alt_phone_no'=>$post->alt_phone_no, 
                    ];
                })
            ];
        });

        return response()->json([
            'success'=> true,
            'data'=> $response
        ]);
        

            
    }

    public function adminPosts(Request $request){
        $adminPosts = Post::where('approved',0)->get();

        
        $basePath = 'https://hoverinsight.com/public/';

        $allPosts=[];

        foreach($adminPosts as $singlePost){
            $category = Category::where('id',$singlePost->category_id)->first();
            $post = [
                    'post_id'=>$singlePost->id,
                    'category'=>$category->name,
                     'user_id'=>$singlePost->user_id,
                     'img' =>$basePath.$singlePost->img,
                     'img2'=>$basePath.$singlePost->img2,
                     'img3'=>($singlePost->img3 !==  null) ? $basePath.$singlePost->img3: null,
                     'img4'=>(($singlePost->img4 !==  null)) ? $basePath.$singlePost->img4: null,
                     'img5'=>(($singlePost->img5 !==  null)) ? $basePath.$singlePost->img5: null,
                     'location'=>$singlePost->location,
                     'title'=>$singlePost->title,
                     'type'=>$singlePost->type, 
                     'product_condition'=>$singlePost->product_condition,
                     'description'=>$singlePost->description,
                     'price'=>$singlePost->price,
                     'negotiable'=>$singlePost->negotiable, 
                     'phone_no'=>$singlePost->phone_no, 
                     'alt_phone_no'=>$singlePost->alt_phone_no, 
                ];
                array_push($allPosts,$post);
        }

        return response()->json([
            'sucess'=> true,
            'message'=>'Unapproved Posts',
            'posts'=> $allPosts
        ],200);

    }

    public function approvePost($approveId,$postId){
        if($approveId==1){
            $post = Post::where('id',$postId)->first();
            $post->approved = 1;
            $post->save();

            return response()->json([
                'sucsess'=>true,
                'message'=>'Post Approved',
            ]);

        }elseif($approveId==0){
            return response()->json([
                'sucsess'=>true,
                'message'=>'Post Not Approved',
            ]);
        }
        else {
            return response()->json([
                'sucsess'=>false,
                'message'=>'Invalid approveId(Must be 0 or 1)',
            ]);
        }
    }
    public function myLikes(Request $request){
        $userId = $request->user()->id;

        $liked = Likes::where('user_id', $userId)->get();

        $likedPosts = [];
        foreach($liked as $like){
            $like =Post::where('id',$like->post_id)->first(); 
            array_push($likedPosts, $like);

        }
        if(empty($likedPosts)){
            return response()->json([
                'success'=>true,
                'message'=>'No Liked Posts'
            ]);
        }

        $basePath = 'https://hoverinsight.com/public/';

        $likes=[];

        foreach($likedPosts as $singlePost){
            $category = Category::where('id',$singlePost->category_id)->first();
            $post = [
                    'post_id'=>$singlePost->id,
                    'category'=>$category->name,
                     'user_id'=>$singlePost->user_id,
                     'img' =>$basePath.$singlePost->img,
                     'img2'=>$basePath.$singlePost->img2,
                     'img3'=>($singlePost->img3 !==  null) ? $basePath.$singlePost->img3: null,
                     'img4'=>(($singlePost->img4 !==  null)) ? $basePath.$singlePost->img4: null,
                     'img5'=>(($singlePost->img5 !==  null)) ? $basePath.$singlePost->img5: null,
                     'location'=>$singlePost->location,
                     'title'=>$singlePost->title,
                     'type'=>$singlePost->type, 
                     'product_condition'=>$singlePost->product_condition,
                     'description'=>$singlePost->description,
                     'price'=>$singlePost->price,
                     'negotiable'=>$singlePost->negotiable, 
                     'phone_no'=>$singlePost->phone_no, 
                     'alt_phone_no'=>$singlePost->alt_phone_no, 
                ];
                array_push($likes,$post);
        }

        return response()->json([
            'success'=>true,
            'message'=>'Liked Posts',
            'likes'=> $likes
        ],200);


    }
    public function toLike(Request $request,$like, $postId){

        $userId = $request->user()->id;
        if($like== 1){
            $likedPost = Likes::create([
                'user_id'=> $userId,
                'post_id'=> $postId
            ]);

            return response()->json([
                'success'=> true,
                'message'=>'Post added to likes'

            ],200);
        }
        elseif($like=0){
            $post = Likes::where('post_id', $postId)->where('user_id', $userId)->first();
            if($post){
                $post->delete();
            }
            return response()->json([
                'success'=> true,
                'message'=>'Post removed from likes'

            ],200);
        }
    }

   
}
