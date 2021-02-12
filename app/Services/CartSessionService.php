<?php

namespace App\Services;

use Session;
use App\Models\Product;

class CartSessionService {
   
    public function getProductToSession() {
        $totalAmount = 0;
        $products = array();
        if (Session::has('cart')) {
            $products = Session::get('cart');
            foreach ($products as $key => $dataProduct) {
                $totalAmount += (int) $dataProduct->amount;
            }
        }
        return array($products, $totalAmount);
    }

    public function addProductToSession($id_product) {        
        $arrProduct = array();
        if (Session::has('cart')) {
            $arrProduct = Session::get('cart');
        }
        $isProductInSession = false;
        foreach ($arrProduct as $key => $dataProduct) {
            if ($dataProduct->id === (int) $id_product) {
                $isProductInSession = true;
                break;
            }
        }
        if ($isProductInSession) {
            return array('alert-danger', 'Товар уже есть в корзине!');
        } else {
            $product = Product::where('id', $id_product)->first();
            Session::push('cart', (object) array('id' => $product->id, 'name' => $product->name, 'amount' => $product->amount));
            return array('alert-success', 'Товар успешно добавлен в корзину');
        }
    }

    public function deleteProduct($id) {
        $productsInCart = Session::get('cart');
        foreach ($productsInCart as $key => $dataProduct) {
            if ((int) $id === $dataProduct->id) {
                array_splice($productsInCart, $key, 1);
            }
        }
        Session::put('cart', $productsInCart);               
        return $this->getProductToSession();
    }

}
