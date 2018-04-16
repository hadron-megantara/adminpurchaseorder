<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Session;
use GuzzleHttp\Client;
use App\Account;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function loginProcess(Request $request){
        $client = new Client;

        if($request->has('email') && $request->has('password')){
            $response = $client->request('POST', env('API_URL', 'http://192.168.1.101:212/api/v1/').'login', [
                    'query' => ['owner' => env('OWNER_ID', 1), 'email' => $request->email, 'password' => $request->password]
                ]);
            $responseData = json_decode($response->getBody()->getContents());

            if($responseData->isError == false){
                $loginData = $responseData->isResponse;
                $userData = ["id" => $loginData->data->id, "email" => $loginData->data->email, "fullname" => $loginData->data->name, "phone" => $loginData->data->phone, "owner" => $loginData->data->owner, "role" => $loginData->data->role, "status" => $loginData->data->status];
                Session::put('user', $userData);

                setcookie(env("LOGIN_COOKIE", 'phpsess'), $loginData->token->value, $loginData->token->expiration + 30*24*3600, '/', env('DOMAIN_COOKIE', ".kangkoding.com"));
                return redirect('/');
            } else{
                return redirect('login')->with('error', 'Email atau kata kunci salah');
            }
        }
    }

    public function logOut(REQUEST $request){
        Session::forget('user');
        Session::flush();

        return redirect('/');
    }
}
