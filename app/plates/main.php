<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Torin - Simple inventory management.</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <?= $block->add('styles') ?>
</head>
<body style="background: #ebebeb;">
  <?= $block->content() ?>

  <!-- TODO: Import this from php file -->
  <div class="modal fade" id="cuel-alert-modal" tabindex="-1" aria-labelledby="cuel-alert-modal-label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div id="cuel-alert-modal-header">
          <span class="modal-title fs-5 fw-bold" id="cuel-alert-modal-title"></span>
        </div>
        <div class="modal-body" id="cuel-alert-modal-body"></div>
        <div class="modal-footer border-top-0 bg-light">
          <div class="me-auto"></div>
          <button type="button" class="btn btn-link text-secondary text-decoration-none" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.6/dist/cdn.min.js"></script>
  <script defer src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
  <?= $plate->add('script.modal') ?>
  <?= $plate->add('script.alert') ?>

  <?= $block->add('scripts') ?>
</body>
</html>
