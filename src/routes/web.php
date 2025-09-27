<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SearchController;

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

Route::post('/purchase/{item}', [PurchaseController::class, 'store'])->name('purchase.store');


Route::get('/items/search', [ItemController::class, 'search'])->name('items.search');


// プロフィール
Route::get('/mypage_first', function () {
    return view('profile.mypage_first');
})->name('mypage_first');
Route::post('/mypage_first',[ProfileController::class, 'updateFirst'])->name('profile.first');
Route::get('/mypage_edit', [ProfileController::class, 'edit'])->middleware('auth')->name('profile.edit');
Route::post('/mypage/mypage_detail', [ProfileController::class, 'update'])->middleware('auth')->name('profile.edit.update');
Route::get('/mypage_bought/', [ProfileController::class, 'buyList'])->middleware('auth')->name('profile.bought');
Route::get('/mypage_sold', [ProfileController::class, 'sellList'])->middleware('auth')->name('profile.sold');

// 住所
Route::get('/purchase/address/{item_id}', [AddressController::class, 'edit'])->middleware('auth')->name('address.edit');
Route::post('/purchase/address/{item_id}', [AddressController::class, 'update'])->middleware('auth')->name('address.update');

//いいね機能
Route::post('/favorites/{product}', [FavoriteController::class, 'toggle'])->middleware('auth')->name('favorites.toggle');

//コメントのやつ
Route::post('/items/{item}/comments', [CommentController::class, 'store'])->name('comments.store');


Route::get('/email/verify', function () {
    return view('auth.verification');
})->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/mypage_first');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '認証メールを再送しました');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/mail-test', function () {
    Mail::raw('Mailhog 接続テスト', function($message) {
        $message->to('test@example.com')
                ->subject('Mailhog Test');
    });

    return 'メール送信済み。Mailhogを確認してね！';
});