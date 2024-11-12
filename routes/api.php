<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function(){
	//User Auth
	Route::post('signUp', 'Api\AccountController@signUp');
	Route::post('forgot', 'Api\AccountController@forgot');
	Route::post('login', 'Api\AccountController@login');
	//FB Login
	Route::post('fbLogin', 'Api\AccountController@fbLogin');
	//gmail Login
	Route::post('gmailLogin', 'Api\AccountController@gmailLogin');
	//Profile Data
	Route::get('getBasicInfo', 'Api\AccountController@getBasicInfo');
	Route::post('updateBasicInfo', 'Api\AccountController@updateBasicInfo');
	//change password
	Route::post('changePassword', 'Api\AccountController@changePassword');
	//Banners
	Route::get('getBanners', 'Api\BannersController@getBanners');
	Route::get('getSubBanners', 'Api\BannersController@getSubBanners');
	//Pages
	//Route::get('getFaq', 'Api\PagesController@getFaq');
	Route::post('getFaq', 'Api\PagesController@getFaq');
	Route::post('getPages', 'Api\PagesController@getPages');
	//Contact
	Route::post('contact_us', 'Api\PagesController@contact_us');
	//Categorie List
	Route::post('getCategories', 'Api\CategoriesController@getCategories');
	//Products
	Route::post('getHomeProducts', 'Api\ProductsController@getHomeProducts');
	Route::post('productListing', 'Api\ProductsController@productListing');
	Route::post('productDetails', 'Api\ProductsController@productDetails');
	//Rating
	Route::post('reviewsubmit', 'Api\RatingController@reviewsubmit');
	Route::post('listReviews', 'Api\RatingController@listReviews');
	//Favorites
	Route::post('addFavorites', 'Api\WishlistsController@addWishlists');
	Route::get('favorites', 'Api\WishlistsController@wishlists');
	// add to cart
	Route::post('addCart', 'Api\CartController@addCart');
	Route::get('listCart', 'Api\CartController@listCart');
	Route::post('updateCartQuantity', 'Api\CartController@updateQuantity');
	Route::post('removeCart', 'Api\CartController@removeCart');
	
	//Shipping Address 
	Route::post('addShippingAddress', 'Api\CheckoutController@addShippingAddress');
	Route::get('listShippingAddress', 'Api\CheckoutController@listShippingAddress');
	Route::post('editShippingAddress', 'Api\CheckoutController@editShippingAddress');
	Route::post('deleteShippingAddress', 'Api\CheckoutController@deleteShippingAddress');
	//Checkout 
	Route::post('getCheckOutAmount', 'Api\CheckoutController@getCheckOutAmount');	
	Route::post('placeOrder', 'Api\CheckoutController@placeOrder');
	Route::get('orderHistory', 'Api\CheckoutController@orderHistory');	
	Route::post('orderDetails', 'Api\CheckoutController@orderDetails');	
	//other APIS
	Route::get('citysList', 'Api\OtherController@getAllCitys');
	Route::get('deliveryTime', 'Api\OtherController@deliveryTime');

	// payemnt APIS
	Route::get('cancle', 'Api\PaymentController@paycancle')->name('api.payment.cancle');
	Route::get('success', 'Api\PaymentController@success')->name('api.payment.success');
	Route::get('/qpay_action_payemnt/{order_id}/{q_id}/{token}','Api\PaymentController@qpay_action_payemnt')->name('api.payment.qpay_action_payemnt');
	Route::get('/qpay_action_return/','Api\PaymentController@qpay_action_return')->name('api.payment.qpay_action_return');
});

