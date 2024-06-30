<?php

namespace App\Http\Controllers\MarketPlace;

use App\Http\Controllers\Controller;
use App\Models\Likes;
use App\Models\Cart;
use App\Models\Post;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function myCart(Request $request){
        $userId = $request->user()->id;
        $cartIds = Cart::select('post_id')->where('user_id', $userId)->get();

        // Gets all the post in Cart
        $cartPosts = [];
        foreach($cartIds as $cartId){
            $post = Post::where('id',$cartId->post_id)->first();
            array_push($cartPosts,$post);
        }
        // Check if cart is empty
        if(empty($cartPosts)){
            return response()->json([
                'success'=> true,
                'message'=>'Cart is empty'
            ],200);
        }

        $basePath = 'https://hoverinsight.com/public/';

        $cart = [];
        foreach($cartPosts as $singlePost){
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
                array_push($cart,$post);
        }

        return response()->json([
            'success'=>true,
            'message'=>'Cart Items below',
            'cart'=> $cart
        ]);
    }

    public function addCart(Request $request,$postId){
        $userId = $request->user()->id;
        $cart = Cart::create([
            'user_id'=> $userId,
            'post_id'=> $postId
        ]);

        return response()->json([
            'success'=>true,
            'message'=>'Post Added to cart successfully'
        ]);
    }

    public function itemQuantity(Request $request, $quantity, $cartItem){
        $cartItem = Cart::where('id',$cartItem)->first();
        $cartItem->quantity = intval($quantity);
        $cartItem->save();


        return response()->json([
            'success'=> true,
            'message'=>'Cart Quantity added',
        ]);

    }
    
}
