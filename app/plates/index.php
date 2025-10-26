<?php echo $layout->load('main', compact('plate')) ?>

<?php echo $block->body() ?>
  <div class="mb-3">
    <?php echo $plate->add('navbar', compact('block', 'url')) ?>
  </div>

  <div class="container mb-3">
    <p class="mb-0">Hello, Rougin Gutib!</p>
  </div>
<?php echo $block->end() ?>
