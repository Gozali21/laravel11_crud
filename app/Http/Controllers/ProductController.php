<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use App\Models\Product;

class ProductController extends Controller
{
    function index(){
        $products = Product::orderBy('created_at','DESC')->get();

        return view('products.list',[
            'products' => $products
        ]);
    }

    function create(){
        return view('products.create');
    }

    function store(Request $request){
        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric',
        ];

        if ($request->image != "") {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if ($request->image != "") {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext; // generate img name
    
            // save img to db and folder
            $image->move(public_path('uploads/products'), $imageName);
    
            $product->image = $imageName;
            $product->save();
        }

        return redirect()->route('products.index')->with('success','Tambah product berhasil');
    }

    function edit($id){
        $product = Product::findOrFail($id);
        return view('products.edit',[
            'product' => $product
        ]);
    }

    function update($id, Request $request){
        $product = Product::findOrFail($id);

        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric',
        ];

        if ($request->image != "") {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.edit',$product->id)->withInput()->withErrors($validator);
        }

        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;

        if ($request->image != "") {
            // delete old img
            File::delete(public_path('uploads/products/'.$product->image));

            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext; // generate img name
    
            // save img to db and folder
            $image->move(public_path('uploads/products'), $imageName);
    
            $product->image = $imageName;
        }

        $product->save();

        return redirect()->route('products.index')->with('success','Ubah product berhasil');
    }

    function destroy($id) {
        $product = Product::findOrFail($id);

        // delete data
        File::delete(public_path('uploads/products/'.$product->image));

        $product->delete();

        return redirect()->route('products.index')->with('success','Hapus product berhasil');
    }
}
