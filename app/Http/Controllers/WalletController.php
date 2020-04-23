<?php

namespace App\Http\Controllers;

use App\PaystackPayments;
use App\User;
use App\Wallet;
use App\WalletTopups;
use App\WalletTransfers;
use Coderatio\PaystackMirror\Actions\Transactions\InitializeTransaction;
use Coderatio\PaystackMirror\Actions\Transactions\VerifyTransaction;
use Coderatio\PaystackMirror\PaystackMirror;
use Coderatio\PaystackMirror\Services\ParamsBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SweetAlert;
use Mail;
use App\Mail\FundsTransferMail as FundsTransferMail;
use App\Mail\FundsReceiptMail as FundsReceiptMail;
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
		$filterBy = request()->filter_by;
		if($filterBy == null){
			$topups = WalletTopups::where("user_id", Auth::user()->id)->get();
			return view("users.wallet_topups", compact("topups"));
		}else{
			$topups = WalletTopups::where("user_id", Auth::user()->id)->where("status", $filterBy)->get();
			return view("users.filtered_wallet_topups", compact("topups", "filterBy"));
		}
	}

	public function transfer_fund (){
		$wallet = Wallet::where("user_id", Auth::user()->id)->first();
		return view("users.transfer_fund", compact("wallet"));
	}


	public function send_fund (Request $request){
		$validatedData = $request->validate([
			'username' => 'required',
			'amount' => 'required',
			]);

		$checkUsername = User::where("username", $request->username)->first();
		$checkWalletBalance = Wallet::where("user_id", Auth::user()->id)->first();
		if($checkUsername == null){
			if($request->amount < 500){
				$error = \Illuminate\Validation\ValidationException::withMessages([
					'username' => ['This username does not exist in our records.'],
					'amount' => ['Minimum transfer amount allowed is NGN500.'],
					]);
				throw $error;
				return back();
			}else{
				$error = \Illuminate\Validation\ValidationException::withMessages([
					'username' => ['This username does not exist in our records.'],
					]);
				throw $error;
				return back();
			}
		}else if($checkUsername->username == Auth::user()->username){
			$error = \Illuminate\Validation\ValidationException::withMessages([
				'username' => ['Funds transfer to self is not allowed.'],
				]);
			throw $error;
			return back();
		}else{
			if($request->amount < 500){
				$error = \Illuminate\Validation\ValidationException::withMessages([
					'amount' => ['Minimum transfer amount allowed is NGN500.'],
					]);
				throw $error;
				return back();
			}else if($request->amount > $checkWalletBalance->balance){
				$error = \Illuminate\Validation\ValidationException::withMessages([
					'amount' => ['Your wallet balance is NGN'.number_format($checkWalletBalance->balance, 2).' Transfer Declined.'],
					]);
				throw $error;
				return back();
			}else{
				$wallet = Wallet::where("username", $request->username)->first();
				$wallet->balance = (double) ($wallet->balance + $request->amount);
				if($wallet->save()){
					$checkWalletBalance->balance = (double) ($checkWalletBalance->balance - $request->amount);
					if($checkWalletBalance->save()){
						return $this->recordTransferTransaction ($checkWalletBalance, $wallet, $request->amount);
					}else{
						alert()->error('Ooooops! something went wrong.', '')->persistent("Dismiss"); 
						return back();
					}
				}else{
					alert()->error('Ooooops! something went wrong.', '')->persistent("Dismiss"); 
					return back();
				}
			}
		}
	}
	
	public function recordTransferTransaction ($sender, $receiver, $amount){
		$transferRecord = new WalletTransfers;
		$transferRecord->ref_number = "#".Str::random(16);
		$transferRecord->sender_id = $sender->user_id;
		$transferRecord->sender = $sender->username;
		$transferRecord->receiver_id = $receiver->user_id;
		$transferRecord->receiver = $receiver->username;
		$transferRecord->amount = $amount;
		if($transferRecord->save()){
			return $this->transferNotificationMails($transferRecord);
		}else{
			alert()->error('Ooooops! something went wrong.', '')->persistent("Dismiss"); 
			return back();	
		}
	}

	public function transferNotificationMails ($transfer){
		try {
			$user = User::find($transfer->sender_id);
			Mail::to($user)->send(new FundsTransferMail($user, $transfer));
		}catch (\Exception $e) {
			report($e);         
		}


		try {
			$user = User::find($transfer->receiver_id);
			Mail::to($user)->send(new FundsReceiptMail($user, $transfer));
		}catch (\Exception $e) {
			report($e);         
		}

		alert()->success('Transfer Of NGN'.number_format($transfer->amount, 2).' To '.$transfer->receiver.' Was Successful.', '')->persistent("Dismiss");
		return back();
	}



	public function transfer_history (){
		$filterBy = request()->filter_by;
		if($filterBy == null){
			$transfers = WalletTransfers::where("sender_id", Auth::user()->id)->orWhere("receiver_id", Auth::user()->id)->get();
			return view("users.transfer_history", compact("transfers"));
		}else{
			$transfers = null;
			if($filterBy == "Sent"){
				$transfers = WalletTransfers::where("sender_id", Auth::user()->id)->get();
			}else{
				$transfers = WalletTransfers::where("receiver_id", Auth::user()->id)->get();
			}
			return view("users.filtered_transfer_history", compact("transfers", "filterBy"));
		}
	}




	/**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
	public function redirectToGateway($id)
	{
		try{
			$payment = PaystackPayments::find($id);
			$yourSecretKeyHere = "sk_test_776b5cf6112445503846c775cf7cc03f016cc5fc";
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
	 	$secretKey = 'sk_test_776b5cf6112445503846c775cf7cc03f016cc5fc';
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
	 

























































































	 public static function countAllTopUpTransactions (){
	 	$countAllTopUpTransactions = WalletTopups::where("user_id", Auth::user()->id)->count();
	 	return $countAllTopUpTransactions;
	 }


	 public static function countCompletedTopUpTransactions (){
	 	$countCompletedTopUpTransactions = WalletTopups::where("user_id", Auth::user()->id)->where("status", "Completed")->count();
	 	return $countCompletedTopUpTransactions;
	 }


	 public static function countInitiatedTopUpTransactions (){
	 	$countInitiatedTopUpTransactions = WalletTopups::where("user_id", Auth::user()->id)->where("status", "Initiated")->count();
	 	return $countInitiatedTopUpTransactions;
	 }


	 public static function countFailedTopUpTransactions (){
	 	$countFailedTopUpTransactions = WalletTopups::where("user_id", Auth::user()->id)->where("status", "Failed")->count();
	 	return $countFailedTopUpTransactions;
	 }

	 public static function countAllTransfers (){
	 	$countAllTransfers = WalletTransfers::where("sender_id", Auth::user()->id)->orWhere("receiver_id", Auth::user()->id)->count();
	 	return $countAllTransfers;
	 }

	 public static function countOutwardTransfers (){
	 	$countOutwardTransfers = WalletTransfers::where("sender_id", Auth::user()->id)->count();
	 	return $countOutwardTransfers;
	 } 

	 public static function countInwardTransfers (){
	 	$countInwardTransfers = WalletTransfers::where("receiver_id", Auth::user()->id)->count();
	 	return $countInwardTransfers;
	 }

	}
