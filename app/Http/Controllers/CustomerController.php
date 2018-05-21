<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DataTables;

class CustomerController extends Controller
{
    public function index(Request $request){
        return view('customer.list');
    }

    public function getCustomer(){
        $client = new Client;
        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'customer/list', [
                'query' => ['owner' => env('OWNER_ID', 1)]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            $customer = $responseData->isResponse->data;
            return Datatables::of($customer)->make();
        } else{
            return 'error';
        }
    }
}
