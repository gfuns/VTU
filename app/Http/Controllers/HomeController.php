<?php

namespace App\Http\Controllers;

use App\Transactions;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $wallet = Wallet::where("user_id", Auth::user()->id)->first();
        $transactions = Transactions::where("user_id", Auth::user()->id)->count();
        return view('users.dashboard', compact("wallet", "transactions"));
    }

    public function transactions (){
        $filterBy = request()->filter_by;
        if($filterBy == null){
            return view("users.transactions");
        }else{
            $transactions = Transactions::where("user_id", Auth::user()->id)->where("status", $filterBy)->get();
            return view("users.filtered_transactions", compact("transactions", "filterBy"));
        }
    }

    public function profile (){
        return view("users.profile");
    }

    public function updateProfile (Request $request){
        $this->validator($request->all())->validate();

        $user = User::find(Auth::user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if($user->save()){

            return back();
        }else{
            
            return back();
        }
    }
    


    public function password (){
     return view("users.password");
 }

 public function beneficiaries (){
    return view("users.beneficiaries");
}









public static function fetchAllTransactions (){
    $allTransactions = Transactions::where("user_id", Auth::user()->id)->get();
    return $allTransactions;
}

public static function countAllTransactions (){
    $countAllTransactions = Transactions::where("user_id", Auth::user()->id)->count();
    return $countAllTransactions;
}

public static function countCompletedTransactions (){
    $countCompletedTransactions = Transactions::where("user_id", Auth::user()->id)->where("status", "Completed")->count();
    return $countCompletedTransactions;
}

public static function countInitiatedTransactions (){
    $countInitiatedTransactions = Transactions::where("user_id", Auth::user()->id)->where("status", "Initiated")->count();
    return $countInitiatedTransactions;
}

public static function countFailedTransactions (){
    $countFailedTransactions = Transactions::where("user_id", Auth::user()->id)->where("status", "Failed")->count();
    return $countFailedTransactions;
}


}
