<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller {

    public function __construct(CartService $CartService) {
        $this->middleware('auth');
        $this->cartService = $CartService;
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
        return response()->json(array('trsTableHtml' => $this->cartService->deleteProduct($request->id)));
    }
    
}
