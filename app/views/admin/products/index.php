<?php

$products = $data;

$pageTitle = 'Admin | Products';

include_once 'app/views/admin/partials/header.php';
?>
<script>
    var confirmQuestion = 'Are you sure that you want to delete this product?';
</script>
<div class="row">
    <div class="col-12 pt-2">
        <h1 class="display-one">Products</h1>
        <div class="mt-2">
            <a href="<?php echo Route::get('AdminProduct/create') ?>">Add product</a>
        </div>
        <table class="table table-bordered table-hover mt-2">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Size</th>
                <th>Price</th>
                <th>View</th>
                <th>Edit</th>
                <th><span class="alert alert-danger">Delete</span></th>
            </tr>
            <?php
            foreach ($products as $product) :
                echo '<tr>';
                echo "<td>" . $product->product_id . "</td>";
                echo "<td>" . $product->name . "</td>";
                echo "<td>" . $product->size . "</td>";
                echo "<td>$" . $product->price . "</td>";
                echo '<td><a href="' . Route::get('AdminProduct/show', ['product_id' => $product->product_id]) . '">View</a></td>';
                echo '<td><a href="' . Route::get('AdminProduct/edit', ['product_id' => $product->product_id]) . '">Edit</a></td>';
                echo '<td><a class="alert alert-danger" href="' . Route::get('AdminProduct/delete', ['product_id' => $product->product_id]) . '"
                onclick="return confirm(confirmQuestion)">Delete</a></td>';
                echo '</tr>';
            endforeach;
            ?>
        </table>
    </div>
</div>
<?php include_once 'app/views/admin/partials/footer.php'; ?>
