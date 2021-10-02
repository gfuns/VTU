<?php

namespace App\Http\Controllers;

use App\DataPlans;
use App\DataTopupTransactions;
use App\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class DataTopupController extends Controller
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

	public function initiateDataTopup (Request $request){
		$validatedData = $request->validate([
			// 'biller' => 'required',
			'phone' => 'required',
			'variation' => 'required',
			'amount' => 'required',
			]);

		$dataPlan =  DataPlans::find($request->variation);

		$topUp = new DataTopupTransactions;
		$topUp->user_id = Auth::user()->id;
		$topUp->username = Auth::user()->username;
		$topUp->ref_number = "#".Str::random(16);
		$topUp->biller = $dataPlan->biller;
		$topUp->biller_code = $dataPlan->biller_code;
		$topUp->dataplan_size = $dataPlan->dataplan_size;
		$topUp->data_plan = $dataPlan->plan;
		$topUp->buying_price = $dataPlan->buying_price;
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


	public function createTransactionRecord ($topUp){
		$transaction = new Transactions;
		$transaction->user_id = $topUp->user_id;
		$transaction->username = $topUp->username;
		$transaction->ref_number = $topUp->ref_number;
		$transaction->amount = $topUp->amount;
		$transaction->service = "Data Topup";
		if($transaction->save()){
			Session::put("RefNumber", $transaction->ref_number);
			return $this->callDataTopUpAPI ($topUp);
		}else{
			alert()->error('Ooooops! Something Went Wrong.', '')->persistent("Dismiss"); 
			return back();
		}
	}





	public function callDataTopUpAPI ($topUp){
		try {
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://www.nellobytesystems.com/APIDatabundleV1.asp?UserID=CK10557&APIKey=JN2UX06B08J09RD7R111R&MobileNetwork=".$topUp->biller_code."&DataPlan=".$topUp->dataplan_size."&MobileNumber=".$topUp->phone."&CallBackURL=http://127.0.0.1:8000/callback/datatopup",
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
		$topUp = DataTopupTransactions::where("ref_number", $refNumber)->first();
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

		$refNumber = Session::get("RefNumber");
		$topUp = DataTopupTransactions::where("ref_number", $refNumber)->first();
		$topUp->orderid = $result->orderid;
		$topUp->status_code = $result->statuscode;
		$topUp->api_status = $result->status;
		$topUp->api_remark = $this->getRemark($result->statuscode);
		if($topUp->save()){
			Session::forget("RefNumber");
			alert()->success('Request received and is currently being processed.', '')->persistent("Dismiss");
			return back();
		}else{
			Session::forget("RefNumber");
			alert()->error('Ooooops! Something Went Wrong.', '')->persistent("Dismiss"); 
			return back();
		}

		// $rate = number_format($result->USD_NGN, 0);
	}

	public function getRemark ($statusCode){
		$remark = null;

		switch ($statusCode) {
			case '100': $remark = "Awaiting Processing"; break;
			case '199': $remark = "Unspecified Error"; break;
			case '300': $remark = "Awaiting Network Response"; break;
			case '399': $remark = "Unspecified Error"; break;
			case '200': $remark = "Success"; break;
			case '201': $remark = "Network Unresponsive"; break;
			case '299': $remark = "Unspecified Error"; break;
			case '400': $remark = "Invalid API Credentials"; break;
			case '401': $remark = "Missing API Credentials"; break;
			case '402': $remark = "Missing User ID"; break;
			case '403': $remark = "Missing API Key"; break;
			case '404': $remark = "Missing Mobile Network"; break;
			case '405': $remark = "Missing Amount"; break;
			case '406': $remark = "Invalid Amount"; break;
			case '407': $remark = "Minimum Amount is NGN100"; break;
			case '408': $remark = "Maximum Amount is NGN50,000"; break;
			case '409': $remark = "Invalid Recipient"; break;
			case '410': $remark = "Invalid API Error1"; break;
			case '411': $remark = "Invalid API Error2"; break;
			case '412': $remark = "Insufficient API Amount"; break;
			case '413': $remark = "Invalid API"; break;
			case '414': $remark = "Invalid Payment Option"; break;
			case '415': $remark = "Insufficient API Store Dealer Amount"; break;
			case '416': $remark = "Insufficient API Store Amount"; break;
			case '417': $remark = "Insufficient Balance"; break;
			case '418': $remark = "Invalid Mobile Network"; break;
			case '499': $remark = "Unspecified Error"; break;
			case '500': $remark = "Order Cancelled by API User"; break;
			case '500': $remark = "Order Cancelled by API User"; break;
			case '501': $remark = "Order Cancelled by Server"; break;
			case '506': $remark = "Server Busy"; break;
			case '507': $remark = "Network Error"; break;
			case '508': $remark = "Your request cannot be processed at this time"; break;
			case '509': $remark = "Your account has been credited back for failed Txn"; break;
			case '510': $remark = "The process failed"; break;
			case '511': $remark = "Transaction Failure"; break;
			case '512': $remark = "Request is not valid"; break;
			case '513': $remark = "Failed recharge"; break;
			case '514': $remark = "Transaction rejected"; break;
			case '515': $remark = "The receivers account is in the wrong state"; break;
			case '516': $remark = "Is not a valid MTN Subscriber"; break;
			case '517': $remark = "Is not eligible for this offer"; break;
			case '518': $remark = "The subscriber you are trying to Buy data for is not eligible"; break;
			case '519': $remark = "You already have a Data Plan yet to be activated"; break;
			case '520': $remark = "You are not gifting to a valid Globacom user"; break;
			case '521': $remark = "Order already completed, cancelled or refunded"; break;
			case '599': $remark = "Unspecified Error"; break;
			case '600': $remark = "Network Error"; break;
			case '601': $remark = "Your request cannot be processed at this time"; break;
			case '602': $remark = "Your account has been credited back for failed Txn"; break;
			case '603': $remark = "The process failed"; break;
			case '604': $remark = "Transaction Failure"; break;
			case '605': $remark = "Failed Recharge"; break;
			case '606': $remark = "By API User"; break;
			case '699': $remark = "Unspecified Error"; break;
			default: $remark = NULL; break;
		}

		return $remark;
	}











































































































	public static function getMTNPlans(){
		$plans = DataPlans::orderBy("selling_price", "asc")->where("biller", "MTN")->get();
		return $plans;
	}

	public static function getMTNFirstPlan(){
		$plan = DataPlans::orderBy("selling_price", "asc")->where("biller", "MTN")->first();
		return $plan->selling_price;
	}

	public static function getGloPlans(){
		$plans = DataPlans::orderBy("selling_price", "asc")->where("biller", "Glo")->get();
		return $plans;
	}

	public static function getGloFirstPlan(){
		$plan = DataPlans::orderBy("selling_price", "asc")->where("biller", "Glo")->first();
		return $plan->selling_price;
	}

	public static function getEtisalatPlans(){
		$plans = DataPlans::orderBy("selling_price", "asc")->where("biller", "9mobile")->get();
		return $plans;
	}

	public static function getEtisalatFirstPlan(){
		$plan = DataPlans::orderBy("selling_price", "asc")->where("biller", "9mobile")->first();
		return $plan->selling_price;
	}

	public static function getAirtelPlans(){
		$plans = DataPlans::orderBy("selling_price", "asc")->where("biller", "Airtel")->get();
		return $plans;
	}

	public static function getAirtelFirstPlan(){
		$plan = DataPlans::orderBy("selling_price", "asc")->where("biller", "Airtel")->first();
		return $plan->selling_price;
	}

}
