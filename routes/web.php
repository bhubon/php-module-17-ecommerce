<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistConstroller;
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

//user Auth
Route::get('/user-login/{email}', [UserController::class, 'userLogin'])->name('user.login');
Route::get('/verify-login/{email}/{otp}', [UserController::class, 'verifyLogin'])->name('login.verify');
Route::get('/logout', [UserController::class, 'userLogout'])->name('user.logout');
Route::get('/userLoginPage', function () {
    return "Login page";
});


//Authenticated routes 
Route::middleware(['custom.auth'])->group(function () {

    //Profile
    Route::post('/profile-create', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile-show', [ProfileController::class, 'show'])->name('profile.show');

    //Product review
    Route::post('/create-product-review', [ProductController::class, 'createReview'])->name('review.store');

    //Wish List
    Route::get('/wishlist', [WishlistConstroller::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistConstroller::class, 'store'])->name('wishlist.store');
    Route::post('/wishlist-delete', [WishlistConstroller::class, 'destroy'])->name('wishlist.destroy');
});
