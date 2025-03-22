<?php
// Order Controller
class OrderController extends Controller
{
    public static $db;

    /**
     * OrderController constructor
     */
    public function __construct()
    {
        self::$db = Connection::connect();
    }

    /**
     * Display orders
     *
     * @return self|Redirect
     */
    public function index()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->user_id;

            $orders = Order::all()->where('user_id', $user_id)->fetch();

            $data = [];
            foreach ($orders as $order) {
                $orderItems = OrderItem::all()
                    ->join(['order_items', 'products'], ['product_id', 'product_id'])
                    ->where('order_id', $order->order_id)
                    ->fetch();

                if (count($orderItems) > 0) {
                    $order->orderItems = $orderItems;
                    $data[] = $order;
                }
            }

                return self::view('orders', $data);
        } else {
            return Redirect::to('Auth/showLogin');
        }
    }

    /**
     * Create an order
     *
     * @throws PDOException
     * @return self|Redirect
     */
    public function create()
    {
        if (Auth::check()) {
            $params = ArrayHelper::clean($_POST);

            if (isset($params['first_name'], $params['last_name'], $params['country'], $params['city'], $params['zip_code'], $params['address'], $params['payment_method'])) {
                $rules = [
                    'first_name' => ['required', 'string'],
                    'last_name' => ['required', 'string'],
                    'country' => ['required', 'string'],
                    'city' => ['required', 'string'],
                    'zip_code' => ['required', 'string'],
                    'address' => ['required', 'string'],
                    'payment_method' => ['required', 'string']
                ];

                $validator = new Validator();
                $validator->validate($params, $rules);

                if ($validator->getErrors()) {
                    $validator->showErrors();
                    return Redirect::withInput($params)->to('Checkout/index');
                }

                $user_id = Auth::user()->user_id;
                $delivery_address = $params['first_name'] . ' ';
                $delivery_address .= $params['last_name'] . ', ';
                $delivery_address .= $params['address'] . ', ';
                $delivery_address .= $params['city'] . ', ';
                $delivery_address .= $params['country'] . ', ';
                $delivery_address .= $params['zip_code'];

                try {
                    self::$db->beginTransaction();

                    $order = new Order();
                    $order->setUser_id($user_id);
                    $order->setDelivery_address($delivery_address);
                    $order->setDelivery_status('Undelivered');
                    $order->setPayment_status('Unpaid');
                    $order->setPayment_method($params['payment_method']);
                    $order->setCreated_at(date('Y-m-d H:i:s', time()));
                    $order_id = $order->create();

                    $cartItems = Cart::all()->where('user_id', $user_id)->fetch();

                    if (count($cartItems) == 0) {
                        return Redirect::withError('Your cart is empty')->to('Product/index');
                    }

                    foreach ($cartItems as $item) {
                        $orderItem = new OrderItem();
                        $orderItem->order_id = $order_id;
                        $orderItem->product_id = $item->product_id;
                        $orderItem->quantity = $item->quantity;
                        $orderItem->create();
                        Cart::delete($item->item_id);
                    }

                    self::$db->commit();
                    return Redirect::withSuccess('You ordered products successfully')->to('Product/index');
                } catch (\PDOException $e) {
                    self::$db->rollback();
                    return self::view('errors/index', $e->getMessage());
                }
            } else {
                return Redirect::withError('All parameters must be sent')->to('Checkout/index');
            }

        } else {
            return Redirect::to('Auth/showLogin');
        }
    }
}
