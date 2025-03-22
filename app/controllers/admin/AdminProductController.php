<?php

class AdminProductController extends ProductController
{
    /**
     * AdminProductController constructor
     *
     * @return Redirect
     */
    public function __construct()
    {
        if (!Auth::isAdmin()) {
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
        return self::adminView('products/index', $products);
    }

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
                return self::adminView('products/show', $product);
            } else {
                return self::view('errors/index', null, 'Product doesn\'t exist');
            }

        } else {
            return Redirect::to('AdminProduct/index');
        }
    }

    /**
     * Display the form for adding a product
     *
     * @return self
     */
    public function create()
    {
        return self::adminView('products/create');
    }

    /**
     * Adding a new product to the database
     *
     * @return Redirect
     */
    public function store()
    {
        $params = ArrayHelper::clean($_POST);

        if (isset($params['name'], $params['size'], $params['price'])) {
            $rules = [
                'name' => ['required', 'string'],
                'size' => ['required', 'string'],
                'price' => ['required', 'numeric']
            ];

            $validator = new Validator();
            $validator->validate($params, $rules);

            if ($validator->getErrors()) {
                $validator->showErrors();
                return Redirect::withInput($params)->to('AdminProduct/create');
            }

            $product = new Product();
            $product->name = $params['name'];
            $product->size = $params['size'];
            $product->price = $params['price'];
            $product->created_at = date('Y-m-d H:i:s', time());

            if ($product->create()) {
                return Redirect::withSuccess('Product is successfully added')->to('AdminProduct/index');
            } else {
                return Redirect::withError('Product is not added. Try again.')->to('AdminProduct/create');
            }

        } else {
            return Redirect::withError('All required parameters must be sent')->to('AdminProduct/create');
        }
    }

    /**
     * Display the form for editing a product
     *
     * @param array $params
     * @return self|Redirect
     */
    public function edit($params)
    {
        if (!empty($params['product_id']) && filter_var($params['product_id'], FILTER_VALIDATE_INT) && $params['product_id'] > 0) {
            $product_id = $params['product_id'];
            $product = Product::get($product_id);

            if ($product) {
                return self::adminView('products/edit', $product);
            } else {
                return self::view('errors/index', null, 'Product doesn\'t exist');
            }

        } else {
            return Redirect::to('AdminProduct/index');
        }
    }

    /**
     * Updating a product
     *
     * @param array $params
     * @ return Redirect
     */
    public function update()
    {
        $params = ArrayHelper::clean($_POST);

        if (isset($params['product_id'], $params['name'], $params['size'], $params['price'])) {
            $rules = [
                'product_id' => ['required', 'int', 'higherThan' => 0],
                'name' => ['required', 'string'],
                'size' => ['required', 'string'],
                'price' => ['required', 'numeric']
            ];

            $validator = new Validator();
            $validator->validate($params, $rules);

            if ($validator->getErrors()) {
                $validator->showErrors();
                return Redirect::withInput($params)->to('AdminProduct/create');
            }

            $product = Product::get($params['product_id']);
            $product->name = $params['name'];
            $product->size = $params['size'];
            $product->price = $params['price'];

            if ($product->update($params['product_id'])) {
                return Redirect::withSuccess('Product is successfully updated')->to('AdminProduct/index');
            } else {
                return Redirect::withError('Product is not updated. Try again.')->to('AdminProduct/create');
            }

        } else {
            return Redirect::withError('All required parameters must be sent')->to('AdminProduct/edit');
        }
    }

    /**
     * Removing a product from the database
     *
     * @param array $params
     * @return Redirect
     */
    public function delete($params)
    {
        if (
            !empty($params['product_id'])
            && filter_var($params['product_id'], FILTER_VALIDATE_INT)
            && ($params['product_id'] > 0)
        ) {
            $product_id = $params['product_id'];

            if (Product::delete($product_id)) {
                return Redirect::withSuccess('Product is successfully deleted')->to('AdminProduct/index');
            } else {
                return Redirect::withError('Product is not removed. Try again')->to('AdminProduct/index');;
            }

        } else {
            return Redirect::withError('You didn\' send the right parameter')->to('AdminProduct/index');
        }
    }

    /**
     * Uploading a product image
     */
    public function uploadImage()
    {
        $params = ArrayHelper::clean($_POST);

        if (
            !empty($params['product_id'])
            && !empty($params['product_name'])
            && !empty($_FILES['file'])
        ) {
            $product_id = $params['product_id'];
            $product_name = $params['product_name'];
            $file = $_FILES['file'];
            $imageLink = File::upload($file, $product_name, 'public/product_images');

            if ($imageLink) {
                $product = Product::get($product_id);
                $product->image = $imageLink;
                $product->update($product_id);
            }
        }
    }
}
