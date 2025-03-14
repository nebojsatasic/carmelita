<?php

$pageTitle = 'My Orders';

$orders = $data;

include_once 'app/views/partials/header.php';

foreach ($orders as $ord) {
    $total = 0;
?>
    <div class="row">
        <div class="col-12 pt-2">
            <h1 class="display-one">Order No. <?php echo $ord->order_id ?> created on <?php echo date('F d, Y \a\t g:i a', strtotime($ord->created_at)) ?></h1>
            <p>Delivery address: <?php echo $ord->delivery_address ?></p>
            <p>Delivery status: <?php echo $ord->delivery_status ?></p>
            <p>Payment method: <?php echo $ord->payment_method ?></p>
            <p>Payment status: <?php echo $ord->payment_status ?></p>
            
            <table class="table table-bordered table-hover">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                <?php
                foreach ($ord->orderItems as $product) :
                    echo '<tr>';
                    echo "<td>" . $product->product_id . "</td>";
                    echo "<td>" . ucfirst($product->name) . "</td>";
                    echo "<td>" . $product->size . "</td>";
                    echo "<td>$" . $product->price . "</td>";
                    echo "<td>" . $product->quantity . "</td>";
                    $sum = $product->price * $product->quantity;
                    $sum = number_format($sum, 2, '.', '');
                    $total += $sum;
                    echo "<td>$" . $sum . "</td>";
                    echo '</tr>';
                endforeach;
                ?>
            </table>
            <p>Subtotal: <span class="text-decoration-underline">$<?php echo $total = number_format($total, 2, '.', '') ?></span></p>
            <?php if ($ord->payment_status == 'Unpaid' && $ord->payment_method == 'PayPal'): ?>
                <p><a href="<?php echo Route::get('Payment/pay', ['total' => $total, 'order_id' => $ord->order_id]) ?>">Pay via Paypal</a></p>
            <?php endif; ?>
        </div>
    </div>
<?php
}
include_once 'app/views/partials/footer.php';
?>
