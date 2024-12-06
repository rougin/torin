<?= $layout->load('main', compact('plate')); ?>

<?= $block->body() ?>
  <div class="mb-3">
    <?php echo $plate->add('navbar', compact('block', 'url')) ?>
  </div>

  <div class="container mb-3">
    <p class="mb-0">Hello, Rougin Gutib!</p>
  </div>
<?= $block->end() ?>
