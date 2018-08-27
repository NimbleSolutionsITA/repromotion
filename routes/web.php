<?php

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

Auth::routes();

//HOME
Route::get('/', 'HomeController@index')->name('home');

//SHOP
Route::get('/shop/{category1?}/{category2?}', 'ShopController@index')->name('shop')->middleware('auth');
Route::get('/shop/{category1}/{category2}/{product}', 'ShopController@show')->name('shop.show')->middleware('auth');
Route::post('/shop', 'ShopController@filter')->name('shop.filter')->middleware('auth');

//CART
Route::get('/cart', 'CartController@index')->name('cart.index')->middleware('auth');
Route::post('/cart', 'CartController@store')->name('cart.store')->middleware('auth');
Route::post('/cartFavorite', 'CartController@storeFavorite')->name('cart.storeFavorite')->middleware('auth');
Route::post('/cart/{product}', 'CartController@update')->name('cart.update')->middleware('auth');
Route::delete('/cart/{product}', 'CartController@destroy')->name('cart.destroy')->middleware('auth');
Route::get('/cart/empty', 'CartController@empty')->name('cart.empty')->middleware('auth');

//CHECKOUT
Route::get('/checkout', 'CheckoutController@index')->name('checkout.index')->middleware('auth');
Route::post('/checkout', 'CheckoutController@store')->name('checkout.store')->middleware('auth');
Route::get('/thankyou', 'ConfirmationController@index')->name('confirmation.index')->middleware('auth');

//COUPONS
Route::post('/coupons', 'CouponsController@store')->name('coupon.store')->middleware('auth');
Route::delete('/coupons', 'CouponsController@destroy')->name('coupon.destroy')->middleware('auth');

//OTHER PAGES
Route::get('/terms-and-conditions', 'TermsAndConditionsController@index')->name('terms-and-conditions')->middleware('auth');
Route::get('/cookie-policy', 'CookiePolicyController@index')->name('cookie-policy')->middleware('auth');
Route::get('/privacy-policy', 'PrivacyPolicyController@index')->name('privacy-policy')->middleware('auth');

//CATALOG SYNC
Route::get('/midocean', 'MidoceanController@index');

Route::get('/midocean-sync', 'MidoceanController@sync');
Route::post('/midocean-storeList', 'MidoceanController@storeList');

Route::get('/midocean/prodinfo', 'MidoceanController@prodinfo');
Route::get('/midocean/printinfo', 'MidoceanController@printinfo');
Route::get('/midocean/priceimport', 'MidoceanController@priceImport');
Route::get('/midocean/price', 'MidoceanController@price');
Route::get('/midocean/printpriceimport', 'MidoceanController@printPriceImport');
Route::get('/midocean/printprice', 'MidoceanController@printprice');
Route::get('/midocean/printprice2', 'MidoceanController@printprice2');
Route::get('/midocean/printprice3', 'MidoceanController@printprice3');
Route::get('/midocean/printprice4', 'MidoceanController@printprice4');
Route::get('/midocean/startprice', 'MidoceanController@startprice');
Route::get('/midocean/stock', 'MidoceanController@stock');

//VOYAGER ADMIN PANEL
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
