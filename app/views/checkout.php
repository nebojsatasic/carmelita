<?php

$pageTitle = 'Checkout';

$items = $data;

if (Session::has('validErrors')) {
    $validErrors = Session::get('validErrors');
    Session::unset('validErrors');
}

if (Session::has('oldInput')) {
    $oldInput = Session::get('oldInput');
    Session::unset('oldInput');
}

$total = 0.00;

include_once 'app/views/partials/header.php';
?>
    <div class="row">
    <div class="col-12 pt-2">
        <h1 class="display-one">Checkout</h1>
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
                echo '</tr>';
            }
            ?>
        </table>
        <p>Subtotal: <span class="text-decoration-underline">$<?php echo number_format($total, 2, '.', '') ?></span> RSD</p>
    </div>
</div>

<div class="row">
    <div class="col-12 pt-2">
        <div class="border rounded mt-5 pl-4 pr-4 pt-4 pb-4">
            <h1 class="display-4">Delivery address</h1>

            <form action="<?php echo Route::get('Order/create') ?>" method="POST">
                <div class="row">
                    <div class="control-group col-12">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" class="form-control" name="first_name" laceholder="First Name" required
                        value="<?php if(isset($oldInput['first_name'])) echo $oldInput['first_name']; ?>">
                    </div>
                    <?php
                    if (isset($validErrors) && key_exists('first_name', $validErrors)) {
                        echo '<div class="col-12 mt-2">';
                        foreach ($validErrors['first_name'] as $error) {
                            echo '<p class="alert alert-danger">' . $error . '</p>';
                        }
                        echo '</div>';
                    }
                    ?>
                    <div class="control-group col-12 mt-2">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Last Name" required
                        value="<?php if(isset($oldInput['last_name'])) echo $oldInput['last_name']; ?>">
                    </div>
                    <?php
                    if (isset($validErrors) && key_exists('last_name', $validErrors)) {
                        echo '<div class="col-12 mt-2">';
                        foreach ($validErrors['last_name'] as $error) {
                            echo '<p class="alert alert-danger">' . $error . '</p>';
                        }
                        echo '</div>';
                    }
                    ?>
                    <div class="control-group col-12">
                        <label for="country">Country</label>
                        <input type="text" id="country" class="form-control" name="country" placeholder="Country" required
                        value="<?php if(isset($oldInput['country'])) echo $oldInput['country']; ?>">
                    </div>
                    <?php
                    if (isset($validErrors) && key_exists('country', $validErrors)) {
                        echo '<div class="col-12 mt-2">';
                        foreach ($validErrors['country'] as $error) {
                            echo '<p class="alert alert-danger">' . $error . '</p>';
                        }
                        echo '</div>';
                    }
                    ?>
                    <div class="control-group col-12 mt-2">
                        <label for="city">City</label>
                        <input type="text" id="city" class="form-control" name="city" placeholder="City" required
                        value="<?php if(isset($oldInput['city'])) echo $oldInput['city']; ?>">
                    </div>
                    <?php
                    if (isset($validErrors) && key_exists('city', $validErrors)) {
                        echo '<div class="col-12 mt-2">';
                        foreach ($validErrors['city'] as $error) {
                            echo '<p class="alert alert-danger">' . $error . '</p>';
                        }
                        echo '</div>';
                    }
                    ?>
                    <div class="control-group col-12 mt-2">
                        <label for="zip_code">ZIP Code</label>
                        <input type="text" id="zip_code" class="form-control" name="zip_code" placeholder="ZIP Code" required
                        value="<?php if(isset($oldInput['zip_code'])) echo $oldInput['zip_code']; ?>">
                    </div>
                    <?php
                    if (isset($validErrors) && key_exists('zip_code', $validErrors)) {
                        echo '<div class="col-12 mt-2">';
                        foreach ($validErrors['zip_code'] as $error) {
                            echo '<p class="alert alert-danger">' . $error . '</p>';
                        }
                        echo '</div>';
                    }
                    ?>
                    <div class="control-group col-12 mt-2">
                        <label for="address">Address</label>
                        <input type="text" id="address" class="form-control" name="address" placeholder="Address" required
                        value="<?php if(isset($oldInput['address'])) echo $oldInput['address']; ?>">
                    </div>
                    <?php
                    if (isset($validErrors) && key_exists('address', $validErrors)) {
                        echo '<div class="col-12 mt-2">';
                        foreach ($validErrors['address'] as $error) {
                            echo '<p class="alert alert-danger">' . $error . '</p>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>

                <div class="mt-2">
                    <label class="form-label">Payment Method</label>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="cash_on_delivery" value="Cash on Delivery" checked>
                        <label class="form-check-label" for="cash_on_delivery">
                            Cash on Delivery
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="PayPal">
                        <label class="form-check-label" for="paypal">
                            PayPal
                        </label>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="control-group col-12 text-center">
                        <button id="btn-submit" class="btn btn-primary">
                            Order
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
    <?php include_once 'app/views/partials/footer.php'; ?>
