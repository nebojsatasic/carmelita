<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo Config::get('domain') ?>">Carmelita</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <?php
        if (Auth::isAdmin()) {
        ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo Route::get('AdminProduct/index') ?>">Admin</a>
        </li>
        <?php
        }
        ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo Route::get('Product/index') ?>">Products</a>
        </li>
        <?php if (Auth::check()) { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo Route::get('Order/index') ?>">My Orders</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo Route::get('Cart/index') ?>">Cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo Route::get('Auth/logout') ?>">Logout</a>
        </li>
        <?php } else { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo Route::get('Auth/showLogin') ?>">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo Route::get('Auth/showRegister') ?>">Register</a>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
