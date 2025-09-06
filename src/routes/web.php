<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;

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

// 商品
Route::get('/', [ItemController::class, 'index'])->name('items.top');
Route::get('/top_mylist', [ItemController::class, 'mylist'])->middleware('auth')->name('items.top_mylist');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.detail');
Route::get('/sell', [ItemController::class, 'sell'])->middleware('auth')->name('items.sell');
Route::post('/sell', [ItemController::class, 'store'])->middleware('auth')->name('items.store');
Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])->middleware('auth')->name('items.purchase');


// プロフィール
Route::get('/mypage_first', [ProfileController::class, 'index'])->middleware('auth', 'verified')->name('mypage_first');
Route::get('/mypage_edit', [ProfileController::class, 'edit'])->middleware('auth')->name('profile.edit');
Route::post('/mypage/mypage_detail', [ProfileController::class, 'update'])->middleware('auth')->name('profile.edit.update');
Route::get('/mypage_bought', [ProfileController::class, 'buyList'])->middleware('auth')->name('profile.bought');
Route::get('/mypage_sold', [ProfileController::class, 'sellList'])->middleware('auth')->name('profile.sold');

// 住所
Route::get('/purchase/address/{item_id}', [AddressController::class, 'edit'])->middleware('auth')->name('address.edit');
Route::post('/purchase/address/{item_id}', [AddressController::class, 'update'])->middleware('auth')->name('address.update');

//いいね機能
Route::post('/favorites/{product}', [FavoriteController::class, 'toggle'])->middleware('auth')->name('favorites.toggle');

//コメントのやつ
Route::post('/items/{item}/comments', [CommentController::class, 'store'])->name('comments.store');