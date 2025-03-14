<?php

class CheckoutController extends Controller
{
    /**
     * Display checkout page
     *
     * @return self|Redirect
     */
    public function index()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->user_id;

            $items = Cart::all()
                ->join(['cart', 'products'], ['product_id', 'product_id'])
                ->where('user_id', $user_id)
                ->fetch();

            return self::view('checkout', $items);
        }
        return Redirect::to('Product/index');
    }
}
