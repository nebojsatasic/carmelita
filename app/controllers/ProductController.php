<?php

class ProductController extends Controller
{
    /**
     * Display a product
     *
     * @param array $params
     * @return self|Redirect
     */
    public function show($params)
    {
        if (!empty($params['product_id']) && filter_var($params['product_id'], FILTER_VALIDATE_INT) && $params['product_id'] > 0) {
            $product_id = $params['product_id'];
            $product = Product::get($product_id);

            if ($product) {
                return self::view('products/show', $product);
            } else {
                return self::view('errors/index', null, 'Product doesn\'t exist');
            }

        } else {
            return Redirect::to('Product/index');
        }
    }

    /**
     * Display all products
     *
     * @return self
     */
    public function index()
    {
        $products = Product::get();
        return self::view('products/index', $products);
    }
}
