<?php

$product = $data;

$pageTitle = 'Admin > ' . $product->name;

include_once 'app/views/admin/partials/header.php';
?>
<script>
    var confirmQuestion = 'Are you sure that you want to delete this product?';
</script>
<div class="row">
    <div class="col-12 pt-2">

        <h1 class="display-one"><?php echo $product->name ?></h1>
        <p>Price: $<?php echo $product->price ?></p>
        <p>Size: <?php echo $product->size ?></p>
        <p><img src="<?php echo Config::get('domain') . $product->image ?>" alt="<?php echo ucfirst($product->name) ?>"></p>

        <div class="mt-2">
            <a href="<?php echo Route::get('AdminProduct/edit', ['product_id' => $product->product_id]) ?>">Edit</a>
        </div>

        <div class="mt-2">
                            <a class="alert alert-danger" href="<?php echo Route::get('AdminProduct/delete', ['product_id' => $product->product_id]) ?>"
                onclick="return confirm(confirmQuestion)">Delete</a>
        </div>

    </div>
</div>
<?php include_once 'app/views/admin/partials/footer.php'; ?>
