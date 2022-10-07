<?php

use App\Http\Controllers\app\CategoryController;
use App\Http\Controllers\app\DeviceController;
use App\Http\Controllers\app\ProductController;
use Illuminate\Support\Facades\Route;

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

$controller_path = 'App\Http\Controllers';
Route::get('/', function () {
  return redirect(route('dashboard'));
});
// Main Page Route
Route::get('/admin', $controller_path . '\dashboard\Analytics@index')->name('dashboard');

// layout
// Route::get('/admin/', $controller_path . '\layouts\WithoutMenu@index')->name('layouts-without-menu');


Route::prefix('admin')->group(function () use ($controller_path) {

  Route::prefix('category')->group(function () use ($controller_path) {
    Route::get('/', $controller_path . '\app\CategoryController@index')->name('category-index');
    Route::get('/create', $controller_path . '\app\CategoryController@create')->name('category-create');
    Route::post('/store', [CategoryController::class, "store"])->name('category-store');
    Route::delete('/destroy/{id}', [CategoryController::class, "destroy"])->name('category-destroy');
    Route::get('/edit/{id}', [CategoryController::class, "edit"])->name('category-edit');
    Route::post('/update/{id}', [CategoryController::class, "update"])->name('category-update');
  });



  Route::prefix('products')->group(function () use ($controller_path) {
    Route::get('/', $controller_path . '\app\ProductController@index')->name('product-index');
    Route::get('/create', $controller_path . '\app\ProductController@create')->name('product-create');
    Route::post('/store', [ProductController::class, "store"])->name('product-store');
    Route::delete('/destroy/{id}', [ProductController::class, "destroy"])->name('product-destroy');
    Route::get('/edit/{id}', [ProductController::class, "edit"])->name('product-edit');
    Route::post('/update/{id}', [ProductController::class, "update"])->name('product-update');
  });
});
