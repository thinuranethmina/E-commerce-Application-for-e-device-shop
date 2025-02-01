<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('frontend.pages.about.index');
})->name('about');

Route::get('/contact', function () {
    return view('frontend.pages.contact.index');
});

Route::get('/contact/submit', [HomeController::class, 'contactSubmit'])->name('contact.submit');

Route::post('/search', [HomeController::class, 'search'])->name('home.search');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::get('/quick-buy/{slug}/{id}', [CheckoutController::class, 'quickBuy'])->name('checkout.quickBuy');
Route::get('/checkout/{ref}', [CheckoutController::class, 'returnIndex'])->name('checkout.return.index');
Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
Route::post('/quick-buy/store', [CheckoutController::class, 'quickStore'])->name('checkout.quickStore');
Route::post('/notify', [CheckoutController::class, 'notify'])->name('checkout.notify');

Route::post('cart/add', [CartController::class, 'store'])->name('cart.add');
Route::post('/cart/change/qty/{id}/{qty}', [CartController::class, 'changeQty'])->name('cart.change.qty');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/shop/{slug}', [ShopController::class, 'detail'])->name('shop.detail');

Route::post('/product/options', [ShopController::class, 'fetchOptions'])->name('shop.product.options');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

Route::post('/shop/product/price/update', [ShopController::class, 'priceUpdate'])->name('shop.product.price.update');
Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

require __DIR__ . '/admin.php';
