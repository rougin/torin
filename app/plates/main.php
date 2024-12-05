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

  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.6/dist/cdn.min.js"></script>
  <script defer src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
  <?= $block->add('scripts') ?>
</body>
</html>
