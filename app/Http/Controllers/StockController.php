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
        return view('stock.list');
    }

    public function getList(Request $request){

    }
}
