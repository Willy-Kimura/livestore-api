<?php

use App\Http\Controllers\BrandCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::resource('categories', CategoryController::class);
Route::resource('discounts', DiscountController::class);
Route::resource('products', ProductController::class);
Route::resource('clients', ClientController::class);
Route::resource('brands', BrandController::class);
Route::get('product', [ProductController::class, 'search']);
Route::get('brands/all', [BrandController::class, 'getAllProductsByBrands']);
Route::get('brand/{name}', [BrandController::class, 'search']);
Route::get('brand/{name}/products', [BrandController::class, 'getProducts']);
Route::get('brand/{name}/categories', [BrandController::class, 'getCategories']);
Route::get('brand-category/{name}', [BrandController::class, 'getProductsAndCategories']);
Route::resource('orders', OrderController::class);
Route::resource('brand-categories', BrandCategoryController::class);
Route::post('orders/products', [OrderController::class, 'addOrderProduct']);
Route::post('brand-categories/populate', [BrandCategoryController::class, 'populate']);
Route::post('products/populate', [ProductController::class, 'populate']);
Route::post('product-brands/update', [ProductController::class, 'updateBrands']);
Route::post('products/update', [ProductController::class, 'updateProducts']);

Route::middleware(['auth'])->group(function () {});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
