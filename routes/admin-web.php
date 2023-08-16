<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SubCategoryControlller;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\SubSubCategoryControlller;

Route::group(['middleware'=> ['auth', 'admin'], 'as'=>'admin.'], function(){

    Route::resource('category', CategoryController::class);
    Route::resource('sub-category', SubCategoryControlller::class);
    Route::resource('sub-sub-category', SubSubCategoryControlller::class);
    Route::post('get-sub-category-ajax',[SubSubCategoryControlller::class,'get_sub_category'])->name('get-sub-category-ajax');
    Route::post('get-sub-sub-category-ajax',[ProductController::class,'get_sub_sub_category'])->name('get-sub-sub-category-ajax');

    Route::resource('brands', BrandController::class);
    Route::resource('sliders', SliderController::class);
    Route::resource('site-setting', SiteSettingController::class);
    Route::resource('attribute', AttributeController::class);
    Route::resource('attribute-value', AttributeValueController::class);
    Route::resource('product', ProductController::class);
    Route::delete('/delete-image/{id}/{imageName}', [ProductController::class, 'deleteImage'])->name('delete.image');

    Route::resource('type',TypeController::class);

    Route::get('order',[OrderController::class,'index'])->name('order.index');
    Route::get('order/{id}/view',[OrderController::class,'view'])->name('order.view');
    Route::post('order/status/update',[OrderController::class,'status_update'])->name('order.status.update');

    Route::post('get-attribute-information',[ProductController::class,'get_attribute_information'])->name('get-attribute-information');

});
