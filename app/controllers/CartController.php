<?php

class CartController extends Controller
{
    /**
     * Show cart items
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

            return self::view('cart', $items);
        }
        return Redirect::to('Product/index');
    }

    /**
     * Adding items to the cart
     *
     * @return Redirect
     */
    public function add()
    {
        if (Auth::check()) {
            $params = ArrayHelper::clean($_POST);

            if (isset($params['product_id'], $params['quantity'])) {
                $rules = [
                    'product_id' => ['required', 'int', 'higherThan' => 0],
                    'quantity' => ['required', 'int', 'higherThan' => 0]
                ];

                $validator = new Validator();
                $validator->validate($params, $rules);

                if (!$validator->getErrors()) {
                    $cart = new Cart();
                    $cart->user_id = Auth::user()->user_id;
                    $cart->product_id = $params['product_id'];
                    $cart->quantity = $params['quantity'];

                    if ($cart->create()) {
                        return Redirect::withSuccess('Product is successfully added to cart')->to('Product/index');
                    } else {
                        return Redirect::withError('product is not added to cart. Try again')->to('Product/show', ['product_id' => $params['product_id']]);
                    }

                }
            }
            return Redirect::to('Product/index');
        }

        return Redirect::to('Auth/showLogin');
    }

    /**
     * Removing items from the cart
     *
     * @param array $params
     * @return Redirect
     */
    public function delete($params)
    {
        if (Auth::check()) {
            if (
                !empty($params['item_id'])
                && filter_var($params['item_id'], FILTER_VALIDATE_INT)
                && ($params['item_id'] > 0)
            ) {
                $item_id = $params['item_id'];

                if (Cart::delete($item_id)) {
                    return Redirect::withSuccess('Product is removed from cart')->to('Cart/index');
                } else {
                    return Redirect::withError('Product is not removed from cart. Try again')->to('Cart/index');;
                }

            } else {
                return Redirect::withError('You didn\' send the right parameter')->to('Cart/index');
            }
        } else {
            return Redirect::to('Auth/showLogin');
        }
    }
}
