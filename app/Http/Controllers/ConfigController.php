<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DataTables;

class ConfigController extends Controller
{
    public function category(Request $request){
        return view('config.category');
    }

    public function getCategory(){
        $client = new Client;
        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/category/get', [
                'query' => ['owner' => env('OWNER_ID', 1)]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            $category = $responseData->isResponse->data;
            return Datatables::of($category)->make();
        } else{
            return 'error';
        }
    }

    public function color(Request $request){
        return view('config.color');
    }

    public function getColor(){
        $client = new Client;
        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/color/get', [
                'query' => ['owner' => env('OWNER_ID', 1)]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            $color = $responseData->isResponse->data;
            return Datatables::of($color)->make();
        } else{
            return 'error';
        }
    }

    public function size(Request $request){
        return view('config.size');
    }

    public function getSize(){
        $client = new Client;
        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/size/get', [
                'query' => ['owner' => env('OWNER_ID', 1)]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            $size = $responseData->isResponse->data;
            return Datatables::of($size)->make();
        } else{
            return 'error';
        }
    }

    public function gender(Request $request){
        return view('config.gender');
    }

    public function getGender(){
        $client = new Client;
        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/gender/get', [
                'query' => ['owner' => env('OWNER_ID', 1)]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            $gender = $responseData->isResponse->data;
            return Datatables::of($gender)->make();
        } else{
            return 'error';
        }
    }
}
