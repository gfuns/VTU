<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
	public function profile (){
		return view("users.profile");
	}

	public function password (){
		return view("users.password");
	}

	public function beneficiaries (){
		return view("users.beneficiaries");
	}

	public function fund_account (){
		return view("users.fund_account");
	}
	
	public function transactions (){
		return view("users.transactions");
	}
	
	public function wallet_topups (){
		return view("users.wallet_topups");
	}
	
	public function transfer_fund (){
		return view("users.transfer_fund");
	}
	
	public function airtime_topup (){
		return view("users.airtime_topup");
	}
	
	public function network_airtime_topup ($param){
		return view("users.network_airtime_topup", compact("param"));
	}

	public function data_topup (){
		return view("users.data_topup");
	}

	public function network_data_topup ($param){
		return view("users.network_data_topup", compact("param"));
	}
	
	public function power_subscription (){
		return view("users.power_subscription");
	}
	
	public function power_subscription_provider ($param){
		$label = null;
		if($param == "aedc-electric"){
			$label = "Abuja Electricity Distribution Company (AEDC) Subscription";
		}else if($param == "eko-electric"){
			$label = "Eko Electricity Distribution Company (EKEDC) Subscription";
		}else if($param == "ikeja-electric"){
			$label = "Ikeja Electricity Distribution Company (IKEDC) Subscription";
		}else if($param == "jos-electric"){
			$label = "Jos Electricity Distribution Company (JEDC) Subscription";
		}else if($param == "kano-electric"){
			$label = "Kano Electricity Distribution Company (KEDC) Subscription";
		}else if($param == "portharcourt-electric"){
			$label = "Port Harcourt Electricity Distribution Company (PHED) Subscription";
		}else if($param == "ibadan-electric"){
			$label = "Ibadan Electricity Distribution Company (IBEDC) Subscription";
		}
		return view("users.power_subscription_provider", compact("param", "label"));
	}
	

	public function cable_subscription (){
		return view("users.cable_subscription");
	}


	public function cable_subscription_provider ($param){
		$label = null;
		if($param == "gotv"){
			$label = "Gotv Subscription";
		}else if($param == "dstv"){
			$label = "Dstv Subscription";
		}else if($param == "startimes"){
			$label = "Startimes Subscription";
		}
		return view("users.cable_subscription_provider", compact("param", "label"));
	}


}
