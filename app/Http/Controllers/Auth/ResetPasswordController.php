<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail as ResetPasswordMail;
use App\Mail\ResetPasswordConfirmationMail as ResetPasswordConfirmationMail;
use App\ResetPassword;
use App\User;
use Illuminate\Http\Request;
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
                    Mail::to($reset)->send(new ResetPasswordMail($reset));
                }catch (\Exception $e) {
                    report($e);         
                }
                Session::flash("displayError", "TRUE");
                return back();
            }
        }
    }

    public function showResetPasswordForm ($token){
        $user = ResetPassword::where("token", $token)->first();
        if($user == null){
            return abort(511);
        }else{
            return view("auth.passwords.reset", compact("user", "token"));
        }
    }

    public function savePasswordChange (Request $request){
        $validatedData = $request->validate([
            'email' => 'required',
            'user_token' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8',
            ]);


        $exist = ResetPassword::where("email", $request->email)->where("token", $request->user_token)->first();
        if($exist == null){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'email' => ['Token rejected.'],
                ]);
            throw $error;
            return back();
        }else if($request->password != $request->password_confirmation){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'password' => ['Passwords do not match.'],
                ]);
            throw $error;
            return back();
        }else{
            $user = User::where("email", $request->email)->first();
            $user->password = bcrypt($request->password);
            $user->save();
            auth()->login($user);

            try {
                Mail::to($user)->send(new ResetPasswordConfirmationMail($user));
            }catch (\Exception $e) {
                report($e);         
            }

            Session::flash("message", "Password Reset Successful.");
            return redirect("/home");
        }
    }



}
