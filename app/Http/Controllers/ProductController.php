<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Session;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Product;
use App\Category;
use App\Gender;
use App\Size;
use App\Color;

class ProductController extends Controller
{
    public function list(){
        return view('product.list');
    }

    public function getList(){
        $client = new Client;
        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'product/list', [
                'query' => ['owner' => env('OWNER_ID', 1)]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            $product = $responseData->isResponse->data->product;

            return Datatables::of($product)->make();
        } else{
            return 'error';
        }
    }

    public function addProduct(Request $request){
        $gender = Gender::all();
        $category = Category::all();
        $color = Color::all();
        $size = Size::all();

        $data = array(
            'category' => $category,
            'gender' => $gender,
            'size' => $size,
            'color' => $size,
        );

        return view('product.add', $data);
    }

    public function addProductProcess(Request $request){
        $userData = Session::get('user');

        $category = '';
        for($i=0;$i < count($request->productCategory); $i++){
            if($category == ''){
                $category = $request->productCategory[$i];
            } else{
                $category = $category.','.$request->productCategory[$i];
            }
        }

        $uploadedList = explode(",",$request->file_upload_list);
        for($j=0;$j < count($uploadedList); $j++){
            if($uploadedList[$j] != ''){
                $explodedPath = explode(",",$uploadedList);
                Storage::move($uploadedList[$j], 'new/file.jpg');
            }
        }

        $product = new Product;
        $product->_Owner = $userData['owner'];
        $product->Name = $request->productName;
        $product->Description = $request->productDescription;
        $product->_Gender = $request->productGender;
        $product->_Category = $category;
        $product->Price = $request->productPrice;
        $product->CreatedDt = Carbon::now()->toDateTimeString();
        $product->CreatedBy = $userData['id'];
        $product->save();

        return redirect('/product/list')->with('success', 'Sukses menambah produk baru');
    }

    public function updateProduct(Request $request){

    }

    public function deleteProduct(Request $request){

    }

    public function getDetail($id, Request $request){
        $client = new Client;
        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'product/detail', [
                'query' => ['owner' => env('OWNER_ID', 1), 'productId' => $id]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            $product = $responseData->isResponse->data->detail;

            $client = new Client;
            $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/discount-type/get', [
                    'query' => ['owner' => env('OWNER_ID', 1)]
                ]);
            $responseData = json_decode($response->getBody()->getContents());
            $discountType = $responseData->isResponse->data;
        } else{
            return view('product.not-found');
        }

        $gender = Gender::all();
        $category = Category::all();

        foreach($product as $product){
            $product = array('name' => $product->Name, 'id' => $product->Id, 'description' => $product->Description, 'gender' => $product->Gender, 'genderId' => $product->GenderId, 'category' => $product->Category, 'categoryId' => $product->CategoryId, 'oldPrice' => $product->oldPrice, 'newPrice' => $product->newPrice, 'discountType' => $product->DiscountType, 'discount' => $product->Discount, 'status' => $product->Status);
        }

        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'product/detail/photo', [
                'query' => ['owner' => env('OWNER_ID', 1), 'productId' => $id]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            $photo = $responseData->isResponse->data->detail;

            $client = new Client;
            $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/color/get', [
                    'query' => ['owner' => env('OWNER_ID', 1)]
                ]);
            $responseData = json_decode($response->getBody()->getContents());

            $color = $responseData->isResponse->data;
        }

        $data = array(
            'category' => $category,
            'gender' => $gender,
            'product' => $product,
            'discountType' => $discountType,
            'color' => $color,
            'photo' => $photo,
        );

        return view('product.detail', $data);
    }

    public function uploadFile(Request $request){
        if($request->file('photo')->isValid()){
            $userData = Session::get('user');

            $uploadedFile = $request->file('photo');
            $uploadededFile = $uploadedFile->store('images/'.$userData['owner'].'/temp');
            echo json_encode(array($uploadededFile));die;
        }
    }

    public function removeFile(Request $request){
        $filename = $request->name;

        Storage::delete($filename);
    }

    public function imageUpload(Request $request){
        if($request->file('file')->isValid()){
            $userData = Session::get('user');

            $uploadedFile = $request->file('file');
            $uploadedFile = $uploadedFile->store('images/'.$userData['owner'].'/temp');
            $uploadedFile = str_replace('"', '', $uploadedFile);
            echo $uploadedFile;die;
        }
    }
}
