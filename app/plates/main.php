<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Torin - Simple inventory management.</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto">
  <?php echo $block->add('styles') ?>
  <style type="text/css">
    html, body { font-family: 'Roboto'; }
    .ex-pointer { cursor: pointer; }
  </style>
</head>
<body style="background: #ebebeb;">
  <?php echo $block->content() ?>

  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.6/dist/cdn.min.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
  <?php echo $plate->add('scripts/modal') ?>
  <?php echo $plate->add('scripts/alert') ?>

  <?php echo $block->add('scripts') ?>
</body>
</html>
