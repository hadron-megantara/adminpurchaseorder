<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Session;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class OrderController extends Controller
{
    public function list(Request $request){
        return view('order.list');
    }

    public function getList(Request $request){
        $client = new Client;

        $limit = env('PRODUCT_LIST_LIMIT', 15);
        if($request->has('length')){
            $limit = $request->length;
        }

        $limitStart = 0;
        if($request->has('start')){
            $limitStart = $request->start;
        }

        $search = null;
        if($request->has('search') && $request->search != ''){
            $search = $request->search;
            $search = $search['value'];
        }

        $orderBy = 0;
        if($request->has('order') && count($request->order) > 0){
            foreach($request->order as $order){
                if($order['dir'] == 'asc'){
                    $orderBy = 1;
                }
            }
        }

        $status = 0;
        if($request->has('status') && $request->status != ''){
            $status = (int) $request->status;
        }

        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'order/list/get', [
                'query' => ['owner' => env('OWNER_ID', 1), 'limit' => $limit, 'limitStart' => $limitStart, 'search' => $search, 'orderBy' => $orderBy, 'status' => $status]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            $order = $responseData->isResponse->data;

            $total = 0;
            if(isset($order[0])){
                $order[0]->TotalData;
            }

            return response()->json([
                'draw' => (int) $request->draw,
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $order,
                'input' => $request->all()
            ]);
        } else{
            return 'error';
        }
    }

    public function detail($id, Request $request){
        $client = new Client;
        $response = $client->request('GET', env('API_URL', 'http://192.168.1.103:212/api/v1/').'order/get', [
            'query' => ['orderCode' => $id]
        ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            $orderData = $responseData->isResponse->data;

            $data = array(
                'order' => $orderData
            );

            return view('order.detail', $data);
        }
    }

    public function updateOrder($id, Request $request){
        $client = new Client;
        $response = $client->request('POST', env('API_URL', 'http://192.168.1.103:212/api/v1/').'order/update', [
            'query' => ['orderCode' => $id, 'status' => $request->status]
        ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            $message = $responseData->isMessage;

            return redirect('/order/detail/'.$id)->with('success', $message);
        }
    }
}
