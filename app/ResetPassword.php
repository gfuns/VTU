<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
	
	public function user (){
		$user = User::where("email", $this->email)->first();
		return $user->username;
	}


}
