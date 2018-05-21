<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Session;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class TestingController extends Controller
{
    public function index(Request $request){
        $client = new Client;

        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'testing/status', [
                'query' => []
            ]);
        $responseData = json_decode($response->getBody()->getContents());
        $orderStatus = $responseData->isResponse->data;

        $data = array(
            'orderStatus' => $orderStatus
        );
        return view('testing', $data);
    }

    public function getOrder(Request $request){
        $limit = 10;
        if($request->has('length')){
            $limit = $request->length;
        }

        $limitStart = 0;
        if($request->has('start')){
            $limitStart = $request->start;
        }

        $status = 9;
        if($request->has('status')){
            $status = $request->status;
        }

        $client = new Client;

        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'testing', [
                'query' => ['status' => $status, 'limit' => $limit, 'limitStart' => $limitStart]
            ]);
        $responseData = json_decode($response->getBody()->getContents());
        $order = $responseData->isResponse->data;

        return response()->json([
            'draw' => (int) $request->draw,
            'recordsTotal' => 9232,
            'recordsFiltered' => 9232,
            'data' => $order,
            'input' => $request->all()
        ]);
    }
}
