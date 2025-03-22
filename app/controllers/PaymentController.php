<?php

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;

class PaymentController extends Controller
{
    /**
     * @var string
     */
    private $clientId = '';

    /**
     * @var string
     */
    private $secret = '';

    /**
     * PaymentController constructor
     */
    public function __construct()
    {
        if (!Auth::check()) {
            return Redirect::to('Auth/showLogin');
        }
    }

    /**
     * Paying via PayPal
     *
     * @param array $params
     * @throws Exception
     * @return self
     */
    public function pay($params)
    {
        if (
            !empty($params['total']) && filter_var($params['total'], FILTER_VALIDATE_FLOAT) && $params['total'] > 0
            && !empty($params['order_id']) && filter_var($params['order_id'], FILTER_VALIDATE_INT) && $params['order_id'] > 0
        ) {
            $total = $params['total'];
            $order_id = $params['order_id'];

            // Set up PayPal API credentials
            $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    $this->clientId,
                    $this->secret
                )
            );

            // Create the payment details (amount, currency, etc.)
            $amount = new Amount();
            $amount->setCurrency("USD")
                ->setTotal($total);  // Total payment amount

            // Set the payer as PayPal
            $payer = new Payer();
            $payer->setPaymentMethod("paypal");

            // Create a transaction
            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setDescription("Payment for items");

            // Set the URLs to redirect after payment approval or cancellation
            $returnUrl = Route::get('Payment/executePayment') . '?order_id=' . $order_id;
            $cancelUrl = Route::get('Payment/cancelPayment');
            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl($returnUrl)   // Success URL
                ->setCancelUrl($cancelUrl);   // Cancel URL

            // Create the payment object
            $payment = new Payment();
            $payment->setIntent("sale")
                ->setPayer($payer)
                ->setTransactions([$transaction])
                ->setRedirectUrls($redirectUrls);

            try {
                // Create the payment
                $payment->create($apiContext);

                // Get the PayPal approval URL and redirect the user to it
                $approvalUrl = $payment->getApprovalLink();

                // Redirect the user to PayPal for approval
                header("Location: $approvalUrl");

            } catch (Exception $ex) {
                // Handle errors
                $error = $ex->getMessage();
                return self::view('errors/index', null, $error);
            }
        } else {
            return self::view('errors/index', null, 'A problem occured while sending parameters');
        }
    }

    /**
     * Executing the payment and changing payment status to 'Paid'
     *
     * @throws Exception
     * @return Redirect
     */
    public function executePayment()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $array = explode('?', $requestUri);
        $part2 = $array[1];
        $params = explode('&', $part2);

        foreach ($params as $param) {
            $arr = explode('=', $param);
            $key = trim(strip_tags($arr[0]));
            $value = trim(strip_tags($arr[1]));
            $$key = $value;
        }

        if (isset($PayerID)) {
            $payerId = $PayerID;
        }

        // Set up PayPal API credentials
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $this->clientId,
                $this->secret
            )
        );

        try {
            // Get the payment object using the payment ID
            $payment = Payment::get($paymentId, $apiContext);

            // Create a payment execution object
            $paymentExecution = new PaymentExecution();
            $paymentExecution->setPayerId($payerId);

            // Execute the payment
            $result = $payment->execute($paymentExecution, $apiContext);

            // Update database
            $order = Order::get($order_id);
            $order->setPayment_status('Paid');
            $order->update($order_id);

            // Handle the result
            $message = 'Payment successful! Payment ID: ' . $paymentId;
            return Redirect::withSuccess($message)->to('Order/index');
        } catch (Exception $ex) {
            // Handle errors
            $message = 'Error executing payment: ' . $ex->getMessage();
            return Redirect::withError($message)->to('Order/index');
        }
    }

    /**
     * Payment cancellation
     *
     * @return Redirect
     */
    public function cancelPayment()
    {
        return Redirect::withError('Payment canceled!')->to('Order/index');
    }
}
