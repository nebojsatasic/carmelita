<?php

$product = $data;

$pageTitle = 'Admin | Edit product';

if (Session::has('validErrors')) {
    $validErrors = Session::get('validErrors');
    Session::unset('validErrors');
}

if (Session::has('oldInput')) {
    $oldInput = Session::get('oldInput');
    Session::unset('oldInput');
}

include_once 'app/views/admin/partials/header.php';
?>
<div class="row">
    <div class="col-12 pt-2">
        <div class="border rounded mt-5 pl-4 pr-4 pt-4 pb-4">
            <h1 class="display-4">Edit product</h1>

            <form action="<?php echo Route::get('AdminProduct/update') ?>" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product->product_id ?>">
                <div class="row">
                    <div class="control-group col-12">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" name="name" placeholder="Name" required
                        value="<?php if(isset($oldInput['name'])) echo $oldInput['name']; else echo $product->name; ?>" autofocus>
                    </div>
                    <?php
                    if (isset($validErrors) && key_exists('name', $validErrors)) {
                        echo '<div class="col-12 mt-2">';
                        foreach ($validErrors['name'] as $error) {
                            echo '<p class="alert alert-danger">' . $error . '</p>';
                        }
                        echo '</div>';
                    }
                    ?>
                    <div class="control-group col-12 mt-2">
                        <label for="size">Size</label>
                        <input type="text" id="size" class="form-control" name="size" placeholder="Size" required
                        value="<?php if(isset($oldInput['size'])) echo $oldInput['size']; else echo $product->size?>">
                    </div>
                    <?php
                    if (isset($validErrors) && key_exists('size', $validErrors)) {
                        echo '<div class="col-12 mt-2">';
                        foreach ($validErrors['size'] as $error) {
                            echo '<p class="alert alert-danger">' . $error . '</p>';
                        }
                        echo '</div>';
                    }
                    ?>
                    <div class="control-group col-12">
                        <label for="price">Price</label>
                        <input type="text" id="price" class="form-control" name="price" placeholder="Price" required
                        value="<?php if(isset($oldInput['price'])) echo $oldInput['price']; else echo $product->price; ?>">
                    </div>
                    <?php
                    if (isset($validErrors) && key_exists('price', $validErrors)) {
                        echo '<div class="col-12 mt-2">';
                        foreach ($validErrors['price'] as $error) {
                            echo '<p class="alert alert-danger">' . $error . '</p>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
                <div class="row mt-2">
                    <div class="control-group col-12 text-center">
                        <button id="btn-submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>
                </div>
            </form>

            <h1 class="display-4">Add / Change picture</h1>
            <ul class="list-group">
                <li class="list-group-item">Allowed file types: jpg, jpeg, png</li>
                <li class="list-group-item">Maximum file size: 2 MB</li>
            </ul>
            <form action="<?php echo Route::get('AdminProduct/uploadImage') ?>" class="dropzone">
                <input type="hidden" name="product_id" value="<?php echo $product->product_id ?>">
                <input type="hidden" name="product_name" value="<?php echo $product->name ?>">
            </form>

        </div>
    </div>
</div>
<?php include_once 'app/views/admin/partials/footer.php'; ?>
