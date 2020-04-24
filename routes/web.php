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

Route::get('/airtimetopup', 'AirtimeTopupController@topUp')->name('airtime.topup');

Auth::routes();

Route::post('/resetPassword', 'Auth\ResetPasswordController@resetPassword')->name('user.resetPassword');
Route::get('/password-reset/{token}', 'Auth\ResetPasswordController@showResetPasswordForm')->name('user.showResetPasswordForm');
Route::post('/savePasswordChange', 'Auth\ResetPasswordController@savePasswordChange')->name('user.savePasswordChange');

Route::get('/configuration', 'ConfigController@wallet_config')->name('configuration');

Route::get('/home', 'HomeController@index')->name('home');

//User Module
Route::get('/settings/profile', 'HomeController@profile')->name('user.profile');

Route::post('/settings/update-profile', 'HomeController@updateProfile')->name('user.updateProfile');

Route::get('/settings/password', 'HomeController@password')->name('user.password');

Route::post('/settings/update-password', 'HomeController@updatePassword')->name('user.updatePassword');

Route::get('/settings/beneficiaries', 'HomeController@beneficiaries')->name('user.beneficiaries');

Route::get('/settings/delete-beneficiary/{id}', 'HomeController@deleteBeneficiary')->name('user.deleteBeneficiary');

Route::get('/transactions', 'HomeController@transactions')->name('user.transactions');

Route::get('/fund-account', 'WalletController@fund_account')->name('user.fund_account');

Route::post('/initiate/fund-account', 'WalletController@intiate_funding')->name('user.callpaystack');

Route::get('/wallet-topups', 'WalletController@wallet_topups')->name('user.wallet_topups');

Route::get('/transfer-fund', 'WalletController@transfer_fund')->name('user.transfer_fund');

Route::post('/initiate/transfer-fund', 'WalletController@send_fund')->name('user.send_fund');

Route::get('/transfer-history', 'WalletController@transfer_history')->name('user.transfer_history');

Route::get('/airtime-topup', 'TestController@airtime_topup')->name('user.airtime_topup');

Route::get('/airtime-topup/{param}', 'TestController@network_airtime_topup')->name('user.network_airtime_topup');

Route::get('/data-topup', 'TestController@data_topup')->name('user.data_topup');

Route::get('/data-topup/{param}', 'TestController@network_data_topup')->name('user.network_data_topup');

Route::get('/power-subscription', 'TestController@power_subscription')->name('user.power_subscription');

Route::get('/power-subscription/{param}', 'TestController@power_subscription_provider')->name('user.power_subscription_provider');

Route::get('/cable-subscription', 'TestController@cable_subscription')->name('user.cable_subscription');

Route::get('/cable-subscription/{param}', 'TestController@cable_subscription_provider')->name('user.cable_subscription_provider');


////////////////////Paystack Thingy////////////////////
Route::get('/payment/callback', 'WalletController@handleGatewayCallback');

////////////////////Airtime Topup////////////////////
Route::post('/airtime/topup/initiate', 'AirtimeTopupController@initiateAirtimeTopup')->name("airtimetopup.initiate");
Route::get('/callback/airtimetopup/{ref}', 'AirtimeTopupController@airtimeTopupCallBack')->name("airtimetopup.callback");

////////////////////Data Topup////////////////////
Route::post('/data/topup/initiate', 'DataTopupController@initiateDataTopup')->name("datatopup.initiate");
Route::get('/callback/datatopup/{ref}', 'AirtimeTopupController@dataTopupCallBack')->name("datatopup.callback");
