<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartSessionService;

class CartSessionController extends Controller {

    public function __construct(CartSessionService $CartSessionService) {        
        $this->cartSessionService = $CartSessionService;
    }
   
    public function index() {
        list($products, $totalAmount) = $this->cartSessionService->getProductToSession();
        return view('cart', compact('products', 'totalAmount'));
    }
    
    
    public function actionGetProducts() {
        return response()->json(array('trsTableHtml' => $this->cartSessionService->getHtmlProductFromSession()));        
    }

    
    public function actionAddProduct(Request $request) {
        list($style, $message) = $this->cartSessionService->addProductToSession($request->id_product);
        return response()->json(array('style' => $style, 'message' => $message));
    }

    public function actionDeleteProductFromSession(Request $request) {        
        return response()->json(array('trsTableHtml' => $this->cartSessionService->deleteProduct($request->id)));
    }
    
}
