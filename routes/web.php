<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/sales_rep/login', [\App\Http\Controllers\Backend\SalesrepController::class, 'login'])->name('sales-login');

Route::get('/salepwd', [\App\Http\Controllers\Backend\DashboardController::class, 'salepwd'])->name('salepwd');

Route::post('/sales_rep/login_submit', [\App\Http\Controllers\Backend\SalesrepController::class, 'login_submit'])->name('sales-loginsubmit');

Route::get('/', function () {
    return view('index');
});

Route::get('/privacy-policy', function () {
    return view('privacy_policy');
});

Route::get('/refund-policy', function () {
    return view('refund_policy');
});

Route::get('/terms-conditions', function () {
    return view('terms_conditions');
});

Auth::routes(['register'=>false]);
// Route::get('dashboard', [CustomAuthController::class, 'dashboard']);
// Route::get('login', [CustomAuthController::class, 'index'])->name('login');
// Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
// Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
// Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
// Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

Route::middleware([IsAdmin::class])->group(function(){
Route::get('/dashboard', [\App\Http\Controllers\Backend\DashboardController::class, 'index']);

Route::get('/salesrep_pwd', [\App\Http\Controllers\Backend\DashboardController::class, 'salesrep_pwd']);

Route::post('/update_notifications', [\App\Http\Controllers\Backend\DashboardController::class, 'update_notifications']);
Route::post('/pusher_notifications', [\App\Http\Controllers\Backend\DashboardController::class, 'pusher_notification']);
Route::post('/view_notifications', [\App\Http\Controllers\Backend\DashboardController::class, 'view_notifications']);


// Route::get('/product', [\App\Http\Controllers\Backend\ProductController::class, 'index']);
// Route::get('/product-add', [\App\Http\Controllers\Backend\ProductController::class, 'add']);

Route::resource('products',\App\Http\Controllers\Backend\ProductController::class);
Route::resource('sales-representative',\App\Http\Controllers\Backend\SalesrepController::class);




Route::resource('distributor',\App\Http\Controllers\Backend\DistributorController::class);
Route::resource('delivery_agent',\App\Http\Controllers\Backend\DeliveryController::class);

Route::resource('customer',\App\Http\Controllers\Backend\CustomerController::class);

Route::get('download_file/{id}', [\App\Http\Controllers\Backend\DistributorController::class, 'download_file']);



Route::get('/orders', [\App\Http\Controllers\Backend\OrdersController::class, 'index']);





Route::get('/user_address', [\App\Http\Controllers\Backend\OrdersController::class, 'user_address']);

Route::get('/orders-view', [\App\Http\Controllers\Backend\OrdersController::class, 'view']);
Route::get('/customer-orders/{slug}', [\App\Http\Controllers\Backend\OrdersController::class, 'customerorder']);

Route::get('/customer-map/{id}', [\App\Http\Controllers\Backend\OrdersController::class, 'customermap']);

Route::get('/retailer-orders', [\App\Http\Controllers\Backend\OrdersController::class, 'retailerorder']);
Route::get('/delivery-orders', [\App\Http\Controllers\Backend\OrdersController::class, 'deliveryorders']);
Route::get('/resheduled', [\App\Http\Controllers\Backend\OrdersController::class, 'resheduled']);
Route::get('/canceled', [\App\Http\Controllers\Backend\OrdersController::class, 'canceled']);
Route::get('/customer-order-list', [\App\Http\Controllers\Backend\OrdersController::class, 'customerorderlist']);
Route::get('/retailer-order-list', [\App\Http\Controllers\Backend\OrdersController::class, 'retailerorderlist']);
Route::get('/deliveryboy-order-list', [\App\Http\Controllers\Backend\OrdersController::class, 'deliveryboyorderlist']);
Route::get('/distributor-order-list', [\App\Http\Controllers\Backend\OrdersController::class, 'distributororderlist']);
Route::post('/order_details', [\App\Http\Controllers\Backend\OrdersController::class, 'order_details']);
Route::post('/order_status', [\App\Http\Controllers\Backend\OrdersController::class, 'order_status']);

//Reports
Route::get('/customer-order-report', [\App\Http\Controllers\Backend\ReportController::class, 'customer_report']);
Route::post('/get_reportlists', [\App\Http\Controllers\Backend\ReportController::class, 'get_reportlists']);


Route::post('/get_distributor_data', [\App\Http\Controllers\Backend\ReportController::class, 'get_distributor_data']);

Route::get('/retailer-order-report', [\App\Http\Controllers\Backend\ReportController::class, 'retailer_report']);
Route::get('/deliveryboy-order-report', [\App\Http\Controllers\Backend\ReportController::class, 'delivery_boy_report']);

Route::get('/distributor_report', [\App\Http\Controllers\Backend\ReportController::class, 'distributor_report']);

Route::post('/get_customer_data', [\App\Http\Controllers\Backend\ReportController::class, 'get_customer_data']);


Route::post('/import_distributor_data', [\App\Http\Controllers\Backend\DistributorController::class, 'import_distributor_data']);


Route::post('/import_sales_data', [\App\Http\Controllers\Backend\SalesrepController::class, 'import_sales_data']);

Route::post('/import_delivery_data', [\App\Http\Controllers\Backend\DistributorController::class, 'import_delivery_data']);



Route::post('/get_distributor_data', [\App\Http\Controllers\Backend\DistributorController::class, 'get_distributor_data']);


Route::post('/get_sales_data', [\App\Http\Controllers\Backend\SalesrepController::class, 'get_sales_data']);




Route::post('/get_retailer_data', [\App\Http\Controllers\Backend\ReportController::class, 'get_retailer_data']);
Route::post('/get_deliveryboy_data', [\App\Http\Controllers\Backend\ReportController::class, 'get_deliveryboy_data']);

Route::resource('retailer', \App\Http\Controllers\Backend\RetailerController::class);
Route::post('/update_status', [\App\Http\Controllers\Backend\RetailerController::class, 'update_status']);

Route::get('/delivery', [\App\Http\Controllers\Backend\DeliveryController::class, 'index']);
Route::get('/delivery-view', [\App\Http\Controllers\Backend\DeliveryController::class, 'view']);
Route::get('/deliveryboyedit', [\App\Http\Controllers\Backend\DeliveryController::class, 'deliveryboyedit']);


Route::get('/feedback/{id}', [\App\Http\Controllers\Backend\FeedbackController::class, 'index']);
Route::post('/feedback_save/{id}', [\App\Http\Controllers\Backend\FeedbackController::class, 'send_mail']);





Route::get('/product-settings', [\App\Http\Controllers\Backend\SettingsController::class, 'index']);

Route::get('/coupon', [\App\Http\Controllers\Backend\CouponController::class, 'index']);
Route::get('/coupon-add', [\App\Http\Controllers\Backend\CouponController::class, 'view']);

Route::get('/user-panel', [\App\Http\Controllers\Backend\UserController::class, 'index']);

//Pincode
Route::get('/pincode', [\App\Http\Controllers\Backend\PincodeController::class, 'index']);
Route::get('/pincode_add', [\App\Http\Controllers\Backend\PincodeController::class, 'add']);
Route::post('/pincode_store', [\App\Http\Controllers\Backend\PincodeController::class, 'store']);
Route::get('/pincode_edit/{id}', [\App\Http\Controllers\Backend\PincodeController::class, 'edit']);
Route::post('/pincode_update/{id}', [\App\Http\Controllers\Backend\PincodeController::class, 'update']);
Route::post('/pincode_status', [\App\Http\Controllers\Backend\PincodeController::class, 'status']);
Route::delete('/pincode_destroy/{id}', [\App\Http\Controllers\Backend\PincodeController::class, 'destroy']);

//import pincode
Route::post('/import_pincode_data', [\App\Http\Controllers\Backend\PincodeController::class, 'import_pincode_data']);
//export pincode
Route::post('/get_pincode_data', [\App\Http\Controllers\Backend\PincodeController::class, 'get_pincode_data']);

//city
Route::get('/city', [\App\Http\Controllers\Backend\CityController::class, 'index']);
Route::get('/city_add', [\App\Http\Controllers\Backend\CityController::class, 'add']);
Route::post('/city_store', [\App\Http\Controllers\Backend\CityController::class, 'store']);
Route::get('/city_edit/{id}', [\App\Http\Controllers\Backend\CityController::class, 'edit']);
Route::post('/city_update/{id}', [\App\Http\Controllers\Backend\CityController::class, 'update']);
Route::post('/city_status', [\App\Http\Controllers\Backend\CityController::class, 'status']);
Route::delete('/city_destroy/{id}', [\App\Http\Controllers\Backend\CityController::class, 'destroy']);
Route::post('/unavalaible_city_destroy', [\App\Http\Controllers\Backend\CityController::class, 'unavalaible_city_destroy']);


//unavailable
Route::get('/unavailable_lists', [\App\Http\Controllers\Backend\CityController::class, 'unavailable_lists']);


Route::get('/wallet', [\App\Http\Controllers\Backend\WalletController::class, 'index']);

// Route::get('dashboard', [CustomAuthController::class, 'dashboard']);
// Route::get('login', [CustomAuthController::class, 'index'])->name('login');
// Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
// Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
// Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
// Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');


Route::get('/push-notificaiton', [\App\Http\Controllers\Backend\DashboardController::class, 'push_notification'])->name('push-notificaiton');
Route::post('/store-token', [\App\Http\Controllers\Backend\DashboardController::class, 'storeToken'])->name('store.token');
Route::post('/send-web-notification', [\App\Http\Controllers\Backend\DashboardController::class, 'sendWebNotification'])->name('send.web-notification');

//Banner Controller
Route::resource('banner',\App\Http\Controllers\Backend\BannerController::class);
Route::post('/banner_status', [\App\Http\Controllers\Backend\BannerController::class, 'banner_status']);


});

Route::get('delivery_agent_map', [\App\Http\Controllers\Backend\DeliveryController::class, 'delivery_map']);

Route::get('/QrCode_cartView/{id}', [\App\Http\Controllers\Backend\DashboardController::class, 'QrCode_cartView'])->name('QrCode_cartView');
Route::post('/QrCode_cartSave', [\App\Http\Controllers\Backend\DashboardController::class, 'QrCode_cartSave'])->name('QrCode_cartSave');

Route::get('get_kms/{id}', [\App\Http\Controllers\Backend\DeliveryController::class, 'get_kms']);




