<?php

namespace App\Http\Controllers;

use App\AirtimeTopupTransactions;
use App\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use SweetAlert;
class AirtimeTopupController extends Controller
{

	public function initiateAirtimeTopup (Request $request){
		$validatedData = $request->validate([
			'biller' => 'required',
			'phone' => 'required',
			'amount' => 'required',
			]);

		if($request->amount < 100){
			$error = \Illuminate\Validation\ValidationException::withMessages([
				'amount' => ['Minimum amount allowed is NGN100.'],
				]);
			throw $error;
			return back();
		}else if($request->amount > 50000){
			$error = \Illuminate\Validation\ValidationException::withMessages([
				'amount' => ['Maximum amount allowed is NGN50,000.'],
				]);
			throw $error;
			return back();
		}else{
			$billerCode = null;
			if($request->biller == "mtn"){
				$billerCode = "01";
			}else if($request->biller == "glo"){
				$billerCode = "02";
			}else if($request->biller == "9mobile"){
				$billerCode = "03";
			}else if($request->biller == "airtel"){
				$billerCode = "04";
			}

			$topUp = new AirtimeTopupTransactions;
			$topUp->user_id = Auth::user()->id;
			$topUp->username = Auth::user()->username;
			$topUp->ref_number = "#".Str::random(16);
			$topUp->biller = ucwords($request->biller);
			$topUp->biller_code = $billerCode;
			$topUp->amount = (double) ($request->amount);
			$topUp->number_recharged = preg_replace("/\+234/", 0, $request->phone);
			$topUp->email = $request->email;
			$topUp->voucher_code = $request->voucher;
			if($topUp->save()){
				return $this->createTransactionRecord ($topUp);
			}else{
				alert()->error('Ooooops! Something Went Wrong.', '')->persistent("Dismiss"); 
				return back();
			}
		}

	}


	public function createTransactionRecord ($topUp){
		$transaction = new Transactions;
		$transaction->user_id = $topUp->user_id;
		$transaction->username = $topUp->username;
		$transaction->ref_number = $topUp->ref_number;
		$transaction->amount = $topUp->amount;
		$transaction->service = "Airtime Topup";
		if($transaction->save()){
			Session::put("RefNumber", $transaction->ref_number);
			return $this->callAirtimeTopUpAPI ($topUp);
		}else{
			alert()->error('Ooooops! Something Went Wrong.', '')->persistent("Dismiss"); 
			return back();
		}
	}





	public function callAirtimeTopUpAPI ($topUp){
		try {
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://www.nellobytesystems.com/APIAirtimeV1.asp?UserID=CK10187557&APIKey=JN2UX06B08J09RD7R1VJ3Y825SD01V4536W3M6U42A4UND69JWLSO3CL9ED5511R&MobileNetwork=".$topUp->biller_code."&Amount=".$topUp->amount."&MobileNumber=".$topUp->phone."&CallBackURL=http://127.0.0.1:8000/callback/airtimetopup",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_TIMEOUT => 30000,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
      // Set Here Your Requesred Headers
					'Content-Type: application/json',
					),
				));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);

			if ($err) {
				return $this->transactionFailed();
				// dd($err);
			} else {
				$result = json_decode($response);
				return $this->TransactionStatus($result);
				// return $this->transactionFailed();
			}
		}catch (\Exception $e) {
			report($e);         
		}
		return $result;
	}


	public function transactionFailed (){
		$refNumber = Session::get("RefNumber");
		$topUp = AirtimeTopupTransactions::where("ref_number", $refNumber)->first();
		$topUp->status = "Failed";
		$topUp->save();

		$transaction = Transactions::where("ref_number", $refNumber)->first();
		$transaction->status = "Failed";
		$transaction->save();

		Session::forget("RefNumber");

		alert()->error('Ooooops! Network Error. Transaction Failed', '')->persistent("Dismiss"); 
		return back();
	}


	public function TransactionStatus($result){
		dd($result);
		alert()->success('Top Up Successful.', '')->persistent("Dismiss");
		return back();
		// $rate = number_format($result->USD_NGN, 0);
	}



}
