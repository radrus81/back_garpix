<?php

namespace App\Services;

use DB;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cart;
use App\Models\Cartitem;
use App\Models\Product;

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
        $totalAmount = 0;
        $dataProducts = [];
        $user = User::find(Auth::id());                             
        $products = $user->cart->cartitems;        
        foreach ($products as $product){
            $modelProduct = Product::find($product->id_product);
            array_push($dataProducts,(object)['id'=>$product->id,'name'=>$modelProduct->name,'amount'=>$modelProduct->amount]);
            $totalAmount += $modelProduct->amount;
        }
        return array($dataProducts, $totalAmount);
    }

}
