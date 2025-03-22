<?php

class AdminOrderController extends Controller
{
    /**
     * @var PDO $db
     */
    public static $db;

    /**
     * AdminOrderController constructor
     *
     * @return Redirect
     */
    public function __construct()
    {
        self::$db = Connection::connect();

        if (!Auth::isAdmin()) {
            return Redirect::to('Product/index');
        }
    }

    /**
     * Display all orders
     *
     * @return self
     */
    public function index()
    {
        $orders = Order::all()->fetch();

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

        return self::adminView('orders', $data);
    }

    /**
     * Change delivery status of an order to 'Delivered'
     *
     * @param array $params
     * @return Redirect
     */
    public function changeToDelivered($params)
    {
        if (
            !empty($params['order_id'])
            && filter_var($params['order_id'], FILTER_VALIDATE_INT)
            && $params['order_id'] > 0
        ) {
            $order_id = $params['order_id'];
            $order = Order::get($order_id);
            $order->setDelivery_status('Delivered');
            $order->update($order_id);

            return Redirect::to('AdminOrder/index');
        } else {
            return Redirect::to('AdminProduct/index');
        }
    }

    /**
     * Change payment status of an order to 'Paid'
     *
     * @param array $params
     * @return Redirect
     */
public function changeToPaid($params)
    {
        if (
            !empty($params['order_id'])
            && filter_var($params['order_id'], FILTER_VALIDATE_INT)
            && $params['order_id'] > 0
        ) {
            $order_id = $params['order_id'];
            $order = Order::get($order_id);
            $order->setPayment_status('Paid');
            $order->update($order_id);

            return Redirect::to('AdminOrder/index');
        } else {
            return Redirect::to('AdminProduct/index');
        }
    }
}
