<?php

namespace App\Http\Controllers;

use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Mail\RegistrationMail as RegistrationMail;
class ConfigController extends Controller
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


	public function wallet_config (){
		$wallet = new Wallet;
		$wallet->user_id = Auth::user()->id;
		$wallet->username = Auth::user()->username;
		if($wallet->save()){
			try {
				$user = Auth::user();
				Mail::to($user)->send(new RegistrationMail($user));
			}catch (\Exception $e) {
				report($e);         
			}

			return redirect("/home");
		}
	}


}
