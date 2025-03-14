<?php

$product = $data;

$pageTitle = $product->name;

include_once 'app/views/partials/header.php';
?>
<div class="row">
    <div class="col-12 pt-2">

        <h1 class="display-one"><?php echo $product->name ?></h1>
        <p>Price: $<?php echo $product->price ?></p>
        <p>Size: <?php echo $product->size ?></p>
        <p><img src="<?php echo Config::get('domain') . $product->image ?>" alt="<?php echo ucfirst($product->name) ?>"></p>

        <div class="mt-2">
            <form method="post" action="<?php echo Route::get('Cart/add') ?>">
                <input type="hidden" name="product_id" value="<?php echo $product->product_id ?>">
                <input name="quantity" type="number" value="1" min="1" class="form-control" placeholder="Quantity">
                <div>
                    <button type="submit" class="btn btn-primary">
                        Add To Cart
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
<?php include_once 'app/views/partials/footer.php'; ?>
