<?php

$products = $data;

$pageTitle = 'Products';

include_once 'app/views/partials/header.php';
?>
<div class="row">
    <div class="col-12 pt-2">
        <h1 class="display-one">Carmelita - T-shirt Shop</h1>
        <table class="table table-bordered table-hover">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Size</th>
                <th>Price</th>
                <th>View</th>
            </tr>
            <?php
            foreach ($products as $product) :
                echo '<tr>';
                echo "<td>" . $product->product_id . "</td>";
                echo "<td>" . $product->name . "</td>";
                echo "<td>" . $product->size . "</td>";
                echo "<td>$" . $product->price . "</td>";
                echo '<td><a href="' . Route::get('Product/show', ['product_id' => $product->product_id]) . '">View</a></td>';
                echo '</tr>';
            endforeach;
            ?>
        </table>
    </div>
</div>
<?php include_once 'app/views/partials/footer.php'; ?>
