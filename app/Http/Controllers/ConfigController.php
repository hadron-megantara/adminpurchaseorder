<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DataTables;
use Session;
use Illuminate\Support\Facades\Storage;

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

    public function addCategory(Request $request){
        $client = new Client;
        $response = $client->request('POST', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/category/add', [
                'query' => ['owner' => env('OWNER_ID', 1), 'category' => $request->category]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            return redirect('/config/category')->with('success', 'Sukses menambah kategori');
        } else{
            return redirect('/config/category')->with('error', 'Gagal menambah kategori');
        }
    }

    public function editCategory(Request $request){
        $client = new Client;
        $response = $client->request('POST', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/category/edit', [
                'query' => ['owner' => env('OWNER_ID', 1), 'categoryId' => $request->categoryId, 'category' => $request->category]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            return redirect('/config/category')->with('success', 'Sukses mengubah kategori');
        } else{
            return redirect('/config/category')->with('error', 'Gagal mengubah kategori');
        }
    }

    public function deleteCategory(Request $request){
        $client = new Client;
        $response = $client->request('POST', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/category/delete', [
                'query' => ['owner' => env('OWNER_ID', 1), 'categoryId' => $request->categoryId]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            return redirect('/config/category')->with('success', 'Sukses menghapus kategori');
        } else{
            return redirect('/config/category')->with('error', 'Gagal menghapus kategori');
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

    public function addColor(Request $request){
        $client = new Client;
        $response = $client->request('POST', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/color/add', [
                'query' => ['owner' => env('OWNER_ID', 1), 'color' => $request->color]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            return redirect('/config/color')->with('success', 'Sukses menambah warna');
        } else{
            return redirect('/config/color')->with('error', 'Gagal menambah warna');
        }
    }

    public function editColor(Request $request){
        $client = new Client;
        $response = $client->request('POST', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/color/edit', [
                'query' => ['owner' => env('OWNER_ID', 1), 'colorId' => $request->colorId, 'color' => $request->color]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            return redirect('/config/color')->with('success', 'Sukses mengubah warna');
        } else{
            return redirect('/config/color')->with('error', 'Gagal mengubah warna');
        }
    }

    public function deleteColor(Request $request){
        $client = new Client;
        $response = $client->request('POST', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/color/delete', [
                'query' => ['owner' => env('OWNER_ID', 1), 'colorId' => $request->colorId]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            return redirect('/config/color')->with('success', 'Sukses menghapus warna');
        } else{
            return redirect('/config/color')->with('error', 'Gagal menghapus warna');
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

    public function info(Request $request){
        $client = new Client;

        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/owner/get', [
            'query' => ['owner' => env('OWNER_ID', 1)]
        ]);

        $responseData = json_decode($response->getBody()->getContents());
        $owner = $responseData->isResponse->data;

        $successMessage = null;

        if(Session::has('success')){
            $successMessage = session('success');
        }

        $data = array(
            'owner' => $owner,
            'success' => $successMessage
        );

        return view('config.info', $data);
    }

    public function editInfo(Request $request){
        $upload = false;
        $client = new Client;

        if($request->has('logoPath') && $request->logoPath != ''){
            $upload = true;
            $response = $client->request('POST', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/owner/edit', [
                'multipart' => [
                    [
                        'name'     => 'owner',
                        'contents' => env('OWNER_ID', 1)
                    ],
                    [
                        'name'     => 'name',
                        'contents' => $request->companyName
                    ],
                    [
                        'name'     => 'address',
                        'contents' => $request->companyAddress
                    ],
                    [
                        'name'     => 'phone',
                        'contents' => $request->companyPhone
                    ],
                    [
                        'name'     => 'file',
                        'contents' => fopen('storage/app/'.$request->logoPath, 'r+')
                    ],
                ]
            ]);
        } else{
            $response = $client->request('POST', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/owner/edit', [
                'query' => [
                    'owner' => env('OWNER_ID', 1),
                    'name' => $request->companyName,
                    'address' => $request->companyAddress,
                    'phone' => $request->companyPhone
                ]
            ]);

        }

        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            $messageInfo = $responseData->message;

            if($upload){
                $filename = $request->logoPath;
                Storage::delete($filename);
            }

            return redirect('config/info')->with('success', $messageInfo);
        }
    }

    public function uploadLogo(Request $request){
        if($request->file('file')->isValid()){
            $uploadedFile = $request->file('file');
            $uploadedFile = $uploadedFile->store('images/temp');
            echo $uploadedFile;die;
        }
    }

    public function removeLogo(Request $request){
        $filename = $request->name;

        Storage::delete($filename);
        die;
    }

    public function bankAccount(Request $request){
        $client = new Client;

        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/bank-list/get');
        $responseData = json_decode($response->getBody()->getContents());

        $bankList = array();
        if($responseData->isError == false){
            $bankList = $responseData->isResponse->data;
        } else{
            return 'error';
        }

        $data = array(
            'bankList' => $bankList
        );

        return view('config.bank-account', $data);
    }

    public function getBankAccount(Request $request){
        $client = new Client;
        $response = $client->request('GET', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/bank-account/get', [
            'query' => ['owner' => env('OWNER_ID', 1)]
        ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            $bankAccount = $responseData->isResponse->data;

            return Datatables::of($bankAccount)->make(true);
        } else{
            return 'error';
        }
    }

    public function addBankAccount(Request $request){
        $userData = session('user');

        $client = new Client;
        $response = $client->request('POST', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/bank-account/add', [
                'query' => [
                    'owner' => env('OWNER_ID', 1),
                    'adminId' => $userData['id'],
                    'accountName' => $request->accountName,
                    'accountNumber' => $request->accountNumber,
                    'bankId' => $request->bank,
                    'accountBranch' => $request->accountBranch
                ]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            return redirect('/config/bank-account')->with('success', $responseData->message);
        } else{
            return redirect('/config/bank-account')->with('error', $responseData->message);
        }
    }

    public function editBankAccount(Request $request){
        $client = new Client;
        $response = $client->request('POST', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/bank-account/edit', [
                'query' => ['owner' => env('OWNER_ID', 1), 'categoryId' => $request->categoryId, 'category' => $request->category]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            return redirect('/config/category')->with('success', 'Sukses mengubah kategori');
        } else{
            return redirect('/config/category')->with('error', 'Gagal mengubah kategori');
        }
    }

    public function deleteBankAccount(Request $request){
        $client = new Client;
        $response = $client->request('POST', env('API_URL', 'http://192.168.1.101:212/api/v1/').'config/bank-account/delete', [
                'query' => ['owner' => env('OWNER_ID', 1), 'categoryId' => $request->categoryId]
            ]);
        $responseData = json_decode($response->getBody()->getContents());

        if($responseData->isError == false){
            return redirect('/config/category')->with('success', 'Sukses menghapus kategori');
        } else{
            return redirect('/config/category')->with('error', 'Gagal menghapus kategori');
        }
    }
}
