<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller {

    public function __construct(CartService $cartService) {
        $this->middleware('auth');
        $this->cartService = $cartService;
    }

    public function index() {
        $this->cartService->moveProductsFromSessionToBase();
        list($products, $totalAmount) = $this->cartService->getProductsForUser();
        return view('cart', compact('products', 'totalAmount'));
    }

    public function actionAddProduct(Request $request) {
        list($style, $message) = $this->cartService->addProduct($request->id_product);
        return response()->json(array('style' => $style, 'message' => $message));
    }

    public function actionDeleteProduct(Request $request) { 
        $route = 'cart';
        list ($products,$totalAmount) = $this->cartService->deleteProduct($request->id);
        return response()->json(array('trsTableHtml' => view('trsTable', compact('products', 'totalAmount', 'route'))->render()));
    }
    
}
