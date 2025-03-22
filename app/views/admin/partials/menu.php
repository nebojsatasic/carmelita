<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo Config::get('domain') ?>">Carmelita</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo Route::get('AdminProduct/index') ?>">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo Route::get('AdminOrder/index') ?>">Orders</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
