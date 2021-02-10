<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cartitem;
use DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        list($products,$totalAmount) = $this->getProductsForUser();
        return view('cart', compact('products', 'totalAmount'));
    }

    public function actionAddProduct(Request $request) {
        $isProductForUser = Cartitem::where(['id_user' => Auth::id(), 'id_product' => $request->id_product])->exists();
        if ($isProductForUser) {
            return response()->json(array('style' => 'alert-danger', 'message' => 'Товар уже есть в корзине!'));
        } else {
            $cartitem = new Cartitem;
            $cartitem->id_product = $request->id_product;
            $cartitem->id_user = Auth::id();
            $cartitem->save();
            return response()->json(array('style' => 'alert-success', 'message' => 'Товар успешно добавлен в корзину'));
        }
    }

    public function actionDeleteProduct(Request $request) {
        $cartitem = Cartitem::find($request->id);
        $cartitem->delete();
        list($products,$totalAmount) = $this->getProductsForUser();
        $deleteProduct = true;
        $trsTableHtml = view('trsTable',compact('products','totalAmount','deleteProduct'))->render();
        return response()->json(array('trsTableHtml' => $trsTableHtml));
    }

    private function getProductsForUser() {
        $products = DB::table('cartitems')
                ->select(DB::raw('cartitems.id,name,amount'))
                ->leftJoin('products', 'products.id', '=', 'cartitems.id_product')
                ->where('id_user',Auth::id())
                ->get();
        $totalAmount = DB::table('cartitems')
                ->where('id_user', Auth::id())
                ->leftJoin('products', 'products.id', '=', 'cartitems.id_product')
                ->sum('amount');
        return array($products,$totalAmount);
    }

}
