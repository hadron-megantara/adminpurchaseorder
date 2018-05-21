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

        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'product/list/admin', [
                'query' => ['owner' => env('OWNER_ID', 1), 'limit' => $limit, 'limitStart' => $limitStart, 'name' => $search]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            $product = $responseData->isResponse->data->product;

            foreach($product as $productKey => $productVal){
                foreach($productVal as $productKey2 => $productVal2){
                    $product[$productKey]->$productKey2 = (string) $productVal2;
                }
            }

            return response()->json([
                'draw' => (int) $request->draw,
                'recordsTotal' => $product[0]->TotalData,
                'recordsFiltered' => $product[0]->TotalData,
                'data' => $product,
                'input' => $request->all()
            ]);
        } else{
            return 'error';
        }
    }

    public function addProduct(Request $request){
        $client = new Client;

        // GET DISCOUNT-TYPE
        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/discount-type/get', [
                'query' => ['owner' => env('OWNER_ID', 1)]
            ]);
        $responseData = json_decode($response->getBody()->getContents());
        $discountType = $responseData->isResponse->data;

        // GET GENDER
        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/gender/get', [
                'query' => ['owner' => env('OWNER_ID', 1)]
            ]);
        $responseData = json_decode($response->getBody()->getContents());
        $gender = $responseData->isResponse->data;

        // GET CATEGORY
        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/category/get', [
                'query' => ['owner' => env('OWNER_ID', 1)]
            ]);
        $responseData = json_decode($response->getBody()->getContents());
        $category = $responseData->isResponse->data;

        // GET COLOR
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
            'category' => $category,
            'gender' => $gender,
            'size' => $size,
            'color' => $color,
            'discountType' => $discountType
        );

        return view('product.add', $data);
    }

    public function addProductProcess(Request $request){
        $userData = Session::get('user');

        $discountStartDt = null;
        $discountEndDt = null;
        $productIsDiscount = $productIsDiscount = $request->productIsDiscount;

        if($request->has('productIsDiscount') && $request->productIsDiscount == 1){
            $discountStartDt = $request->discountStartDt.' '.$request->discountStartHour.':'.$request->discountStartMin.':00';

            if($request->has('discountEndDt') && $request->discountEndDt != ''){
                $discountEndDt = $request->discountEndDt.' '.$request->discountEndHour.':'.$request->discountEndMin.':00';
            }
        }

        $client = new Client;

        try{
            $response = $client->request('POST', env('API_URL', 'http://192.168.1.101:212/api/v1/').'product/add', [
                    'form_params' => [ 'owner' => env('OWNER_ID', 1), 'productName' => $request->productName,
                                    'productCategory' => $request->productCategory, 'productGender' => $request->productGender,
                                    'productPrice' => $request->productPrice, 'productIsDiscount' => $productIsDiscount,
                                    'productDiscountVal' => $request->productDiscountVal, 'productDiscountType' => $request->productDiscountType,
                                    'producDiscountStartDt' => $discountStartDt, 'producDiscountEndDt' => $discountEndDt,
                                    'productDescription' => $request->productDescription, 'adminId' => $userData['id'] ]
            ]);

            $responseData = json_decode($response->getBody()->getContents());
        } catch(RequestException $e){
            return redirect('/product/list')->with('error', 'Gagal menambah produk baru');
        }

        $photoPath = array();
        for($i=1;$i<count($request->photoPath);$i++){
            $selected = 0;
            if(str_replace('new', '', $request->selectedPhotoId) == $i){
                $selected = 1;
            }

            if($request->selectedPhotoId == null && $i == 1){
                $selected = 1;
            }

            try{
                $response = $client->request('POST', env('API_URL', 'http://192.168.1.101:212/api/v1/').'product/image/add', [
                    'multipart' => [
                        [
                            'name'     => 'owner',
                            'contents' => env('OWNER_ID', 1)
                        ],
                        [
                            'name'     => 'adminId',
                            'contents' => $userData['id']
                        ],
                        [
                            'name'     => 'productId',
                            'contents' => $responseData->isResponse->data->id
                        ],
                        [
                            'name'     => 'productUuid',
                            'contents' => $responseData->isResponse->data->Uuid
                        ],
                        [
                            'name'     => 'selected',
                            'contents' => $selected
                        ],
                        [
                            'name'     => 'colorId',
                            'contents' => $request->photoColor[$i]
                        ],
                        [
                            'name'     => 'file',
                            'contents' => fopen('storage/app/'.$request->photoPath[$i], 'r+')
                        ],
                    ]
                ]);
            }  catch(RequestException $e){
                return redirect('/product/list')->with('error', 'Gagal Upload Foto');
            }
        }

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

    public function imageUpload(Request $request){
        if($request->file('file')->isValid()){
            $uploadedFile = $request->file('file');
            $uploadedFile = $uploadedFile->store('images/temp');
            echo $uploadedFile;die;
        }
    }

    public function remove(Request $request){
        $filename = $request->name;

        Storage::delete($filename);
        die;
    }
}
