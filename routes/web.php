<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Affiliate\DashboardController as AffiliateDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::group(['middleware'=> ['login']], function(){
    Route::get('admin/login',[LoginController::class,'login'])->name('admin.login');
    Route::post('login',[LoginController::class,'login_submit']);
});
Route::get('logout',function(){
    Auth::logout();
    return redirect()->route('home');
});
Route::get('unauthorized', function () {
    return view('unauthorized');
})->name('unauthorized');

Route::group(['middleware'=> ['auth', 'admin'], 'as'=>'admin.','prefix'=>'admin'], function(){
    Route::get('dashboard',[AdminDashboardController::class,'dashboard'])->name('dashboard');
    Route::resource('ad-type-category','App\Http\Controllers\Admin\AdTypeCategoryController');
    Route::resource('ad-type','App\Http\Controllers\Admin\AdTypeController');
    Route::resource('adpackage','App\Http\Controllers\Admin\AdPackageController');


});

Route::group(['middleware'=> ['auth', 'customer'], 'as'=>'customer.','prefix'=>'customer'], function(){
    Route::get('dashboard',[CustomerDashboardController::class,'dashboard'])->name('dashboard');




});

Route::group(['middleware'=> ['auth', 'affiliate'], 'as'=>'affiliate.','prefix'=>'affiliate'], function(){
    Route::get('dashboard',[AffiliateDashboardController::class,'dashboard'])->name('dashboard');
    Route::get('customer',[AffiliateDashboardController::class,'customer'])->name('login.customer');
    Route::get('seller',[AffiliateDashboardController::class,'seller'])->name('login.seller');

    Route::get('customer/dashboard','App\Http\Controllers\Frontend\HomeController@userDashboard')->name('dashboard');
    Route::get('customer/post-your-ads','App\Http\Controllers\Frontend\HomeController@postAd')->name('post.ad');

});

Route::group(['middleware'=> ['auth', 'seller'], 'as'=>'seller.','prefix'=>'seller'], function(){
    Route::get('dashboard',[SellerDashboardController::class,'dashboard'])->name('dashboard');
    Route::get('customer',[SellerDashboardController::class,'customer'])->name('login.customer');
    Route::get('affiliate',[SellerDashboardController::class,'affiliate'])->name('login.affiliate');
});


Route::get('/','App\Http\Controllers\Frontend\HomeController@home')->name('home');

