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

Route::get('/', function () {
	return view('welcome');
});

Route::get('/dash', function () {
	return view('users.dashboard');
});

Auth::routes();

Route::get('/configuration', 'ConfigController@wallet_config')->name('configuration');
Route::get('/home', 'HomeController@index')->name('home');

//User Module
Route::get('/settings/profile', 'HomeController@profile')->name('user.profile');
Route::post('/settings/update-profile', 'HomeController@updateProfile')->name('user.updateProfile');
Route::get('/settings/password', 'HomeController@password')->name('user.password');
Route::post('/settings/update-password', 'HomeController@updatePassword')->name('user.updatePassword');
Route::get('/settings/beneficiaries', 'HomeController@beneficiaries')->name('user.beneficiaries');
Route::get('/fund-account', 'TestController@fund_account')->name('user.fund_account');
Route::post('/fund-account', 'TestController@callPayStack')->name('user.callpaystack');
Route::get('/transactions', 'HomeController@transactions')->name('user.transactions');
Route::get('/wallet-topups', 'TestController@wallet_topups')->name('user.wallet_topups');
Route::get('/transfer-fund', 'TestController@transfer_fund')->name('user.transfer_fund');
Route::get('/airtime-topup', 'TestController@airtime_topup')->name('user.airtime_topup');
Route::get('/airtime-topup/{param}', 'TestController@network_airtime_topup')->name('user.network_airtime_topup');
Route::get('/data-topup', 'TestController@data_topup')->name('user.data_topup');
Route::get('/data-topup/{param}', 'TestController@network_data_topup')->name('user.network_data_topup');
Route::get('/power-subscription', 'TestController@power_subscription')->name('user.power_subscription');
Route::get('/power-subscription/{param}', 'TestController@power_subscription_provider')->name('user.power_subscription_provider');
Route::get('/cable-subscription', 'TestController@cable_subscription')->name('user.cable_subscription');
Route::get('/cable-subscription/{param}', 'TestController@cable_subscription_provider')->name('user.cable_subscription_provider');


////////////////////Paystack Thingy////////////////////
Route::get('/card_pay/paystack/{id}', 'PaymentController@redirectToGateway')->name('paystack_payment');
// Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay'); 
Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');
Route::get('/cabinet/home', 'CoinPaymentController@back_to_dashboard')->name("coin_back_home");
Route::post('/callback/ipn', 'IPNHandlerCoinPayment@callback_ipn')->name('coinpayment.callback_ipn');