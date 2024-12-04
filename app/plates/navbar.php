<div class="navbar py-0 navbar-expand-lg bg-black" data-bs-theme="dark">
  <div class="container py-3">
    <span class="navbar-brand mb-1 h1"><?= getenv('APP_NAME') ?></span>
    <div class="collapse navbar-collapse d-flex" id="navbarNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?= $url->set('/') ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= $url->set('/items') ?>">Items</a>
        </li>
      </ul>
    </div>
  </div>
</div>
