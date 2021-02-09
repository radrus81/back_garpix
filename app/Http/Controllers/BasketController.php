<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basket;
use DB;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $dataBasket = $this->getProductsForUser();
        $products = $dataBasket['products'];
        $totalAmount = $dataBasket['totalAmount'];
        return view('home', compact('products', 'totalAmount'));
    }

    public function actionAddProduct(Request $request) {
        $isProductForUser = Basket::where(['id_user' => Auth::id(), 'id_product' => $request->id_product])->count();
        if ($isProductForUser) {
            return response()->json(array('style' => 'alert-danger', 'message' => 'Товар уже присутствует в базе!'));
        } else {
            $basket = new Basket;
            $basket->id_product = $request->id_product;
            $basket->id_user = Auth::id();
            $basket->save();
            return response()->json(array('style' => 'alert-success', 'message' => 'Товар успешно добавлен в корзину'));
        }
    }

    public function actionDeleteProduct(Request $request) {
        $basket = Basket::find($request->id);
        $basket->delete();
        $dataBasket = $this->getProductsForUser();
        $products = $dataBasket['products'];
        $totalAmount = $dataBasket['totalAmount'];
        $deleteProduct = true;
        $trsTableHtml = view('trsTable',compact('products','totalAmount','deleteProduct'))->render();
        return response()->json(array('trsTableHtml' => $trsTableHtml));
    }

    private function getProductsForUser() {
        $products = DB::table('baskets')
                ->select(DB::raw('baskets.id,name,amount'))
                ->leftJoin('products', 'products.id', '=', 'baskets.id_product')
                ->where('id_user',Auth::id())
                ->get();
        $totalAmount = DB::table('baskets')
                ->where('id_user', Auth::id())
                ->leftJoin('products', 'products.id', '=', 'baskets.id_product')
                ->sum('amount');
        return array('products'=>$products,'totalAmount'=>$totalAmount);
    }

}
