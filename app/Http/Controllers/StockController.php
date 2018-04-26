<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Session;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class StockController extends Controller
{
    public function list(Request $request){
        $client = new Client;
        $response = $client->request('GET', env('API_URL', 'http://192.168.1.103:212/api/v1/').'product/name', [
            'query' => ['owner' => env('OWNER_ID', 1)]
        ]);
        $responseData = json_decode($response->getBody()->getContents());
        $product = $responseData->isResponse->data->product;

        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/color/get', [
                'query' => ['owner' => env('OWNER_ID', 1)]
            ]);
        $responseData = json_decode($response->getBody()->getContents());
        $color = $responseData->isResponse->data;

        // GET SIZE
        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/size/get', [
                'query' => ['owner' => env('OWNER_ID', 1)]
            ]);
        $responseData = json_decode($response->getBody()->getContents());
        $size = $responseData->isResponse->data;

        $data = array(
            'product' => $product,
            'color' => $color,
            'size' => $size
        );

        return view('stock.list', $data);
    }

    public function getList(Request $request){
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

        $client = new Client;
        $response = $client->request('GET', env('API_URL', 'http://192.168.1.103:212/api/v1/').'product/stock', [
            'query' => ['owner' => env('OWNER_ID', 1), 'orderBy' => $orderBy, 'limit' => $limit, 'limitStart' => $limitStart]
        ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            $order = $responseData->isResponse->data->stock;

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

    public function add(Request $request){
        $userData = Session::get('user');

        $client = new Client;
        $response = $client->request('GET', env('API_URL', 'http://192.168.1.103:212/api/v1/').'product/stock/add', [
            'query' => ['owner' => env('OWNER_ID', 1), 'productId' => $request->stockName, 'color' => $request->stockColor, 'size' => $request->stockSize, 'total' => $request->stockTotal, 'adminId' => $userData['id']]
        ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            return redirect('stock/list')->with('success', $responseData->isMessage);
        }
    }
}
