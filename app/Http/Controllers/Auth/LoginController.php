<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Session;
use App\Account;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function loginProcess(Request $request){
        $account = Account::where('email', $request->email)->first();

        if($account){
            if (Hash::check($request->password, $account->Password)) {
                $userData = ["id" => $account->Id, "email" => $account->Email, "fullname" => $account->Fullname, "phone" => $account->Phone, "owner" => $account->_Owner, "role" => $account->_Role, "status" => $account->Status];
                Session::put('user', $userData);

                return redirect('/');
            } else{
                return redirect('login')->with('error', 'Email atau kata kunci salah');
            }
        } else{
            return redirect('login')->with('error', 'Email atau kata kunci salah');
        }
    }

    public function logOut(REQUEST $request){
        Session::forget('user');
        Session::flush();

        return redirect('/');
    }
}
