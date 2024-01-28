<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProductController;
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

Route::get('/', function () {
    return view('welcome');
});

//Brand List
Route::get('/brand-list', [BrandController::class, 'BrandList']);

//Category List
Route::get('/category-list', [CategoryController::class, 'CategoryList']);

//Product List
Route::get('/product-by-category/{id}', [ProductController::class, 'ListProductByCategory']);
Route::get('/product-by-brand/{id}', [ProductController::class, 'ListProductByBrand']);
Route::get('/product-by-remark/{remark}', [ProductController::class, 'ListProductByRemark']);

//Slider
Route::get('/product-slider', [ProductController::class, 'ListProductSlider']);

//Product Details
Route::get('/product-details-by-id/{id}', [ProductController::class, 'ProductDetailsById']);
Route::get('/review-by-product/{product_id}', [ProductController::class, 'ListReviewById']);

//Policy
Route::get('/policy-by-type/{type}', [PolicyController::class, 'PolicyByType']);
