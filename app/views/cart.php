<?php

$pageTitle = 'Cart';

$items = $data;

include_once 'app/views/partials/header.php';

$total = 0;
?>
<script>
    var removeQuestion = 'Do you really want to remove this product from cart?';
</script>
<div class="row">
    <div class="col-12 pt-2">
        <h1 class="display-one">Cart</h1>
        <table class="table table-bordered table-hover">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Size</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Remove</th>
            </tr>
            <?php
            foreach ($items as $item) {
                echo '<tr>';
                echo '<td>' . $item->product_id . '</td>';
                echo '<td>' . $item->name . '</td>';
                echo '<td>' . $item->size . '</td>';
                echo '<td>$' . $item->price . '</td>';
                echo '<td>' . $item->quantity . '</td>';
                $sum = $item->quantity * $item->price;
                $total += $sum;
                echo '<td>$' . number_format($sum, 2, '.', '') . '</td>';
                echo '<td><a href="' . Route::get('Cart/delete', ['item_id' => $item->item_id]) . '" onclick="return confirm(removeQuestion)">Remove</a></td>';
                echo '</tr>';
            }
            ?>
        </table>
        <p>Subtotal: <span class="text-decoration-underline">$<?php echo number_format($total, 2, '.', '') ?></span></p>
        <div class="mt-2">
            <a href="<?php echo Route::get('Checkout/index') ?>" class="btn btn-outline-primary btn-sm">Checkout</a>
        </div>
    </div>
</div>
    <?php include 'app/views/partials/footer.php'; ?>
