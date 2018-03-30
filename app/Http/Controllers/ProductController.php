<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Session;
use Carbon\Carbon;
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
        $customers = Product::select(['Id', 'Name', 'Description', 'Price'])->orderBy('UpdatedDt', 'desc');

        return Datatables::of($customers)->make();
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
        $userData = Session::get('user');

        $product = Product::where('Id', $id)->where('_Owner', $userData['owner'])->get();

        if($product && count($product) > 0){
            $gender = Gender::all();
            $category = Category::all();

            foreach($product as $product){
                $product = array('name' => $product->Name, 'id' => $product->Id, 'description' => $product->Description, 'gender' => $product->_Gender, 'category' => $product->_Category, 'price' => $product->Price, 'status' => $product->Status);
            }

            $data = array(
                'category' => $category,
                'gender' => $gender,
                'product' => $product,
            );

            return view('product.detail', $data);
        } else{
            return view('product.not-found');
        }
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


}
