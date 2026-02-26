<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\WishlistController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group([
    'prefix' => 'v1',
    'as' => 'api',
    'middleware' => ['auth:api']
], function () {
    //lists all users
    Route::post('/all-user', [ApiController::class, 'allUsers'])->name('all-user');
    Route::post('/store_token', [AuthController::class, 'storeToken']);
    
    Route::get('/user_details', [AuthController::class, 'user_details']);
    //Cart
    Route::post('add_to_cart', [CartController::class, 'add_to_cart']);
    Route::delete('delete_cart', [CartController::class, 'delete_cart']);
    Route::get('cart_lists', [CartController::class, 'cart_lists']);

    
    //wishlist
    Route::post('add_to_wishlist', [WishlistController::class, 'add_to_wishlist']);
    Route::post('delete_wishlist', [WishlistController::class, 'delete_wislist']);
    Route::get('wishlist_lists', [WishlistController::class, 'wishlist_lists']);
     
    //Order
    Route::post('payment/init', [OrderController::class, 'initiate_payment']);
    Route::get('payment/api', [OrderController::class, 'payment_api']);
    Route::post('/check/orders', [OrderController::class, 'check_order']);
    Route::post('checkout', [OrderController::class, 'checkout']);

    Route::get('order_lists', [OrderController::class, 'order_lists']);
    Route::post('order_details', [OrderController::class, 'order_details']);
    Route::post('distributor_orderLists', [OrderController::class, 'distributor_orderLists']);
    Route::post('distributor_orderDetails', [OrderController::class, 'distributor_orderDetails']);
    Route::get('report_details', [OrderController::class, 'report_details']);
    
    Route::post('delivery_orderLists', [OrderController::class, 'delivery_orderLists']);
    Route::post('deliveryboy_orderstatus', [OrderController::class, 'deliveryboy_order_status']);
    
    
    Route::post('user_address', [OrderController::class, 'user_address']);
    Route::get('get_user_address', [OrderController::class, 'get_user_address']);
    Route::post('delete_user_address', [OrderController::class, 'delete_user_address']);
    Route::post('update_defaultaddress', [OrderController::class, 'update_defaultaddress']);
    
    Route::get('notifications', [OrderController::class, 'notifications']);
    Route::post('remove_notification', [OrderController::class, 'remove_notification']);
    Route::put('unread_notification', [OrderController::class, 'unread_notification']);
    Route::get('notification_count', [OrderController::class, 'notification_count']);
    
    Route::post('update_user', [UserController::class, 'update_user']);
  
  
  //products
Route::get('products', [ProductController::class, 'products']);
  Route::post('product_details/{id}', [ProductController::class, 'product_details']);
Route::get('all_products', [ProductController::class, 'all_products']);

Route::get('most_like', [ProductController::class, 'most_like']);
Route::post('feedback', [ProductController::class, 'feedback']);
});

//auth routes
Route::post('v1/user-register', [AuthController::class, 'register']);
Route::post('v1/user-login', [AuthController::class, 'login']);
Route::get('v1/get_users', [AuthController::class, 'get_user']);
Route::post('v1/user-logout', [AuthController::class, 'userlogout']);
    Route::get('v1/delivery_chargelist', [AuthController::class, 'delivery_chargelist']);

//Otp Login
Route::post('v1/send_otp', [AuthController::class, 'send_otp']);
Route::post('v1/verify_otp', [AuthController::class, 'verify_otp']);
Route::get('v1/list_pincode', [AuthController::class, 'list_pincode']);
    


Route::post('v1/is_service_available', [AuthController::class, 'check_pincode']);
    
//Banner 
Route::get('v1/banner_view', [BannerController::class, 'view']);


Route::post('/v1/check_notification', [OrderController::class, 'check_notification']);


Route::post('v1/sockettest', [BannerController::class, 'sockettest']);


