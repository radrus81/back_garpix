<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
   
    public function actionGetProducts(){
        $products = Product::all();
        return view('index', compact('products'));
    }
    
    public function sortProducts(Request $request){
       $products = Product::orderBy($request->field,$request->typeSort)->get();
       $trsTableHtml = view('trsTable',compact('products'))->render();
       return response()->json(array('trsTableHtml' => $trsTableHtml)); 
    }
}
