<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail as ResetPasswordMail;
use App\ResetPassword;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Mail;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';


    public function resetPassword (Request $request){

        $validatedData = $request->validate([
            'email' => 'required',
            ]);

        $exist = User::where("email", $request->email)->first();

        if($exist == null){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'email' => ['This email does not exist on our records.'],
                ]);
            throw $error;
            return back();
        }else{       
            $reset = new ResetPassword;
            $reset->email = $request->email;
            $reset->token = Str::random(60);
            if($reset->save()){
                try {
                    Mail::to($user)->send(new ResetPasswordMail($reset));
                }catch (\Exception $e) {
                    report($e);         
                }
                Session::flash("displayError", "TRUE");
                return back();
            }
        }
    }



}
