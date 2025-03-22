<?php

$pageTitle = 'Register';

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
            <h1 class="display-4">Register</h1>

            <form action="<?php echo Route::get('Auth/register') ?>" method="POST">
                <div class="row">
                    <div class="control-group col-12">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" name="name" placeholder="Name" required
                        value="<?php if(isset($oldInput['name'])) echo $oldInput['name']; ?>" autofocus>
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
                        <label for="username">Username</label>
                        <input type="text" id="username" class="form-control" name="username" placeholder="Username" required
                        value="<?php if(isset($oldInput['username'])) echo $oldInput['username']; ?>">
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
                    <div class="control-group col-12">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control" name="email" placeholder="Email" required
                        value="<?php if(isset($oldInput['email'])) echo $oldInput['email']; ?>">
                    </div>
                    <?php
                    if (isset($validErrors) && key_exists('email', $validErrors)) {
                        echo '<div class="col-12 mt-2">';
                        foreach ($validErrors['email'] as $error) {
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
                    <div class="control-group col-12 mt-2">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                    </div>
                    <?php
                    if (isset($validErrors) && key_exists('password_confirmation', $validErrors)) {
                        echo '<div class="col-12 mt-2">';
                        foreach ($validErrors['password_confirmation'] as $error) {
                            echo '<p class="alert alert-danger">' . $error . '</p>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
                <div class="row mt-2">
                    <div class="control-group col-12 text-center">
                        <button id="btn-submit" class="btn btn-primary">
                            Register
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<?php include_once 'app/views/partials/footer.php'; ?>
