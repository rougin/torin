<div class="navbar py-0 navbar-expand-lg bg-black shadow-lg" data-bs-theme="dark">
  <div class="container py-3">
    <span class="navbar-brand mb-1 h1"><?php echo getenv('APP_NAME') ?></span>
    <div class="collapse navbar-collapse d-flex" id="navbarNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <?php if ($url->isActive('/')): ?>
            <div class="nav-link active fw-bold">Home</div>
          <?php else: ?>
            <a class="nav-link" href="<?php echo $url->set('/') ?>">Home</a>
          <?php endif ?>
        </li>
        <li class="nav-item">
          <?php if ($url->isActive('/orders')): ?>
            <div class="nav-link active fw-bold">Orders</div>
          <?php else: ?>
            <a class="nav-link" href="<?php echo $url->set('/orders') ?>">Orders</a>
          <?php endif ?>
        </li>
        <li class="nav-item">
          <?php if ($url->isActive('/clients')): ?>
            <div class="nav-link active fw-bold">Clients</div>
          <?php else: ?>
            <a class="nav-link" href="<?php echo $url->set('/clients') ?>">Clients</a>
          <?php endif ?>
        </li>
        <li class="nav-item">
          <?php if ($url->isActive('/items')): ?>
            <div class="nav-link active fw-bold">Items</div>
          <?php else: ?>
            <a class="nav-link" href="<?php echo $url->set('/items') ?>">Items</a>
          <?php endif ?>
        </li>
      </ul>
    </div>
  </div>
</div>
