<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SweetAlert;
class AirtimeTopupController extends Controller
{

	public function initiateAirtimeTopu (Request $request){
		$validatedData = $request->validate([
			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required',
			'phone' => 'required',
			]);

		
	}





	public function topUp (){
		try {
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://www.nellobytesystems.com/APIAirtimeV1.asp?UserID=CK10187557&APIKey=JN2UX06B08J09RD7R1VJ3Y825SD01V4536W3M6U42A4UND69JWLSO3CL9ED5511R&MobileNetwork=01&Amount=100&MobileNumber=07037382623&CallBackURL=http://127.0.0.1:8000/callback/airtimetopup",
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
			}
		}catch (\Exception $e) {
			report($e);         
		}
		return $result;
	}


	public function transactionFailed (){
		alert()->error('Ooooops! Network Error.', '')->persistent("Dismiss"); 
		return back();
	}


	public function TransactionStatus($result){
		alert()->success('Top Up Successful.', '')->persistent("Dismiss");
		return back();
		// dd($result);
		// $rate = number_format($result->USD_NGN, 0);
	}



}
