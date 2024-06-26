<?php

use App\Http\Controllers\ReportUser\ReportController;
use App\Http\Controllers\Devices\DeviceController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\MarketPlace\CategoryController;
use App\Http\Controllers\MarketPlace\PostController;
use App\Http\Controllers\MarketPlace\CartController;
use App\Http\Controllers\HiringService\HiringServiceController;
use App\Http\Controllers\User\ProfileController;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Authentication
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/third-party-signin', [AuthController::class, 'thirdPartySignIn'])->name('thirdPartySignIn');
Route::post('/verify-otp', [AuthController::class, 'VerifyOTP'])->name('verifyOtp');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/get-otp', [AuthController::class, 'getOtp'])->name('getOtp');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::get('/admin-reports', [ReportController::class,'adminReports'])->name('adminReports');
Route::get('/post-categories', [CategoryController::class, 'postCategories'])->name('postCategories');
Route::get('/profession-categories', [CategoryController::class, 'professionCategories'])->name('professionCategories');





Route::group(['middleware' => 'auth:sanctum'], function () {

// Profile
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
Route::post('profile-edit', [ProfileController::class, 'profileEdit'])->name('profileEdit');
Route::post('profile-picture-upload', [ProfileController::class, 'profilePictureUpload'])->name('profilePictureUpload');


// Report
Route::post('/report', [ReportController::class, 'report'])->name('report');
Route::get('/report-history', [ReportController::class, 'reportHistory'])->name('reportHistory');
Route::get('{reprtId}/single-report', [ReportController::class, 'singleReport'])->name('singleReport');


// Devices
Route::get('/list-devices', [DeviceController::class, 'listDevices'])->name('listDevices');
Route::post('/add-device', [DeviceController::class, 'addDevice'])->name('addDevice');
Route::get('/my-devices', [DeviceController::class, 'userDevices'])->name('userDevices');

// Contact Us
Route::post('/contact-us', [ContactController::class, 'contactUs'])->name('contactUs');


// MarketPlace
// Posts
Route::post('/post-ad', [PostController::class, 'postAd'])->name('postAd');
Route::get('{postId}/single-post', [PostController::class, 'singlePost'])->name('singlePost');
Route::get('my-posts', [PostController::class, 'myPosts'])->name('myPosts');
Route::get('all-posts', [PostController::class, 'allPosts'])->name('allPosts');

// Cart
Route::get('my-cart', [CartController::class, 'myCart'])->name('myCart');
Route::post('add-cart', [CartController::class, 'addCart'])->name('addCart');
Route::post('{cartId}/remove-cart-item', [CartController::class, 'removeCartItem'])->name('removeItem');
Route::post('{quantity}/{cartItem}/item-quantity', [CartController::class, 'itemQuantity'])->name('itemQuantity');



// Likes
Route::get('my-likes', [PostController::class, 'mylikes'])->name('myLikes');
Route::get('{like}/to-like', [PostController::class, 'toLike'])->name('toLike');

// Admin
Route::get('admin-posts', [PostController::class, 'adminPosts'])->name('adminPosts');
Route::post('{approveId}/{postId}/approve-post', [PostController::class, 'approvePost'])->name('approvePost');





// Proffesional Hiring Services 
Route::post('register-service', [HiringServiceController::class, 'registerService'])->name('registerService');
Route::get('services', [HiringServiceController::class, 'services'])->name('services');
Route::get('{serviceId}/view-service', [HiringServiceController::class, 'view-service'])->name('view-service');


    
});