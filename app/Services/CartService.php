<?php

namespace App\Services;

use DB;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Cartitem;

class CartService {

    
    public function moveProductsFromSessionToBase() {
        $cartUser = Cart::firstOrCreate(['id_user' => Auth::id()]);
        if (Session::has('cart')) {
            $productsFromSession = Session::get('cart');            
            foreach ($productsFromSession as $key=>$productFromSession){
                $isProductInCart = $productsFromCart = Cartitem::where('id_cart', $cartUser->id)->where('id_product',$productFromSession->id)->exists();
                if (!$isProductInCart){
                    $cartitem = new Cartitem;
                    $cartitem->id_cart = $cartUser->id;
                    $cartitem->id_product = $productFromSession->id;
                    $cartitem->save();
                }
            }
         Session::forget('cart');       
        }
    }

    public function addProduct($id_product) {
        $cartUser = Cart::firstOrCreate(['id_user' => Auth::id()]);
        $isProductForUser = Cartitem::where(['id_cart' => $cartUser->id, 'id_product' => $id_product])->exists();
        if ($isProductForUser) {
            return array('alert-danger', 'Товар уже есть в корзине!');
        } else {
            $cartitem = new Cartitem;
            $cartitem->id_cart = $cartUser->id;
            $cartitem->id_product = $id_product;
            $cartitem->save();
            return array('alert-success', 'Товар успешно добавлен в корзину');
        }
    }

    public function deleteProduct($id) {
        $cartitem = Cartitem::find($id);
        $cartitem->delete();                
        return $this->getProductsForUser();
    }

    public function getProductsForUser() {
        $cartUser = Cart::where('id_user', Auth::id())->first();
        $products = DB::table('cartitems')
                ->select(DB::raw('cartitems.id,name,amount'))
                ->leftJoin('products', 'products.id', '=', 'cartitems.id_product')
                ->where('id_cart', $cartUser->id)
                ->get();
        $totalAmount = DB::table('cartitems')
                ->where('id_cart', $cartUser->id)
                ->leftJoin('products', 'products.id', '=', 'cartitems.id_product')
                ->sum('amount');
        return array($products, $totalAmount);
    }

}
