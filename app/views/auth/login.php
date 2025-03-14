<?php

$pageTitle = 'Login';

if (Session::has('validErrors')) {
    $validErrors = Session::get('validErrors');
    Session::unset('validErrors');
}

if (Session::has('oldInput')) {
    $oldInput = Session::get('oldInput');
    Session::unset('oldInput');
}

include_once 'app/views/partials/header.php';
?>
<div class="row">
    <div class="col-12 pt-2">
        <div class="border rounded mt-5 pl-4 pr-4 pt-4 pb-4">
            <h1 class="display-4">Login</h1>

            <form action="<?php echo Route::get('Auth/login') ?>" method="POST">
                <div class="row">
                    <div class="control-group col-12 mt-2">
                        <label for="username">Username</label>
                        <input type="text" id="username" class="form-control" name="username" placeholder="Username" required
                        value="<?php if(isset($oldInput['username'])) echo $oldInput['username']; ?>" autofocus>
                    </div>
                    <?php
                    if (isset($validErrors) && key_exists('username', $validErrors)) {
                        echo '<div class="col-12 mt-2">';
                        foreach ($validErrors['username'] as $error) {
                            echo '<p class="alert alert-danger">' . $error . '</p>';
                        }
                        echo '</div>';
                    }
                    ?>
                    <div class="control-group col-12 mt-2">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <?php
                    if (isset($validErrors) && key_exists('password', $validErrors)) {
                        echo '<div class="col-12 mt-2">';
                        foreach ($validErrors['password'] as $error) {
                            echo '<p class="alert alert-danger">' . $error . '</p>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
                <div class="row mt-2">
                    <div class="control-group col-12 text-center">
                        <button id="btn-submit" class="btn btn-primary">
                            Login
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<?php include_once 'app/views/partials/footer.php'; ?>
