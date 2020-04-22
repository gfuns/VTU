<?php

namespace App\Http\Controllers;

use App\PaystackPayments;
use App\Wallet;
use App\WalletTopups;
use Coderatio\PaystackMirror\Actions\Transactions\InitializeTransaction;
use Coderatio\PaystackMirror\Actions\Transactions\VerifyTransaction;
use Coderatio\PaystackMirror\PaystackMirror;
use Coderatio\PaystackMirror\Services\ParamsBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SweetAlert;
class WalletController extends Controller
{

	/**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct()
	{
		$this->middleware('auth');
	}


	public function fund_account (){
		return view("users.fund_account");
	}

	public function intiate_funding (Request $request){
		$validatedData = $request->validate([
			'amount' => 'required',
			]);
		$topup = new WalletTopups;
		$topup->user_id = Auth::user()->id;
		$topup->username = Auth::user()->username;
		$topup->paystack_ref = PaystackMirror::generateReference();
		$topup->ref_number = "#".Str::random(16);
		$topup->amount = (double) $request->amount;
		if($topup->save()){
			$payment = new PaystackPayments;
			$payment->user_id = $topup->user_id;
			$payment->username = $topup->username;
			$payment->reference = $topup->paystack_ref;
			$payment->amount_naira = $topup->amount;
			$payment->amount_kobo = ($topup->amount * 100);
			if($payment->save()){
				return $this->redirectToGateway($payment->id);
			}else{
				alert()->error('Ooooops! something went wrong.', '')->persistent("Dismiss"); 
				return back();
			}
		}else{
			alert()->error('Ooooops! something went wrong.', '')->persistent("Dismiss"); 
			return back();
		}
	}


	public function wallet_topups (){
		return view("users.wallet_topups");
	}

	public function transfer_fund (){
		return view("users.transfer_fund");
	}




	/**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
	public function redirectToGateway($id)
	{
		try{
			$payment = PaystackPayments::find($id);
			$yourSecretKeyHere = "sk_test_c3c10f66b19a7960ec61ed459f7ffea8a29327c4";
			$actionParams = new ParamsBuilder();
			$actionParams->email = Auth::user()->email;
			$actionParams->amount = $payment->amount_kobo;
    		// $actionParams->amount = naira_to_kobo('1,000');
			$actionParams->reference = $payment->reference;

			$result = PaystackMirror::run($yourSecretKeyHere, new InitializeTransaction($actionParams));
    		// echo $result->getResponse()->asObject();
			$response = $result->getResponse()->asObject();
    		// dd($response);
			return redirect($response->data->authorization_url);
		}catch (\Exception $e) {
			alert()->error('Ooooops! Network Error.', '')->persistent("Dismiss");
			return redirect("/fund-account");
		}
	}


	 /**
     * Obtain Paystack payment information
     * @return void
     */
	 public function handleGatewayCallback(Request $request)
	 {
	 	$secretKey = 'sk_test_c3c10f66b19a7960ec61ed459f7ffea8a29327c4';
	 	$payment = PaystackMirror::run($secretKey, new VerifyTransaction($request->reference))
	 	->getResponse()->asObject();

	 	if (! isset($payment->data)) {
	 		alert()->error('Ooooops! Network Error.', '')->persistent("Dismiss");
	 		return redirect("/fund-account");
	 	}

    	// dd($payment->data);
    	// $response = $payment->data;
	 	$pay = PaystackPayments::where("reference", $payment->data->reference)->first();
	 	$pay->payment_channel = ucwords($payment->data->channel);
	 	$pay->payment_date = now();
	 	if($pay->save()){
	 		$topup = WalletTopups::where("user_id", Auth::user()->id)->where("paystack_ref", $pay->reference)->first();
	 		$topup->status = "Completed";
	 		if($topup->save()){
	 			return $this->updateWallet($topup->id);
	 		}else{
	 			alert()->error('Ooooops! Something Went Wrong.', '')->persistent("Dismiss");
	 			return redirect("/fund-account");
	 		}
	 	}else{
	 		alert()->error('Ooooops! Something Went Wrong.', '')->persistent("Dismiss");
	 		return redirect("/fund-account");
	 	}
	 }

	 public function updateWallet ($id){
	 	$topup = WalletTopups::find($id);
	 	$wallet = Wallet::where("user_id", Auth::user()->id)->first();
	 	$wallet->balance = (double) ($wallet->balance + $topup->amount);
	 	if($wallet->save()){
	 		alert()->success('Top Up of NGN'.number_format($topup->amount, 2).' Was Successful.', '')->persistent("Dismiss");
	 		return redirect("/fund-account");
	 	}else{
	 		alert()->error('Ooooops! Something Went Wrong.', '')->persistent("Dismiss");
	 		return redirect("/fund-account");
	 	}
	 }
	 

	}
