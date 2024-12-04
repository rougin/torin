<?= $layout->load('main'); ?>

<?= $block->body() ?>
  <div class="mb-5">
    <?= $plate->add('navbar', compact('block', 'url')) ?>
  </div>

  <div class="container mb-3">
    <?= $form->buttonLink('< Back to Items', $url->set('items'), 'btn btn-light shadow-lg') ?>
  </div>

  <div class="container mb-3">
    <div class="card shadow-lg">
      <div class="card-body">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit illum totam vero dolorem unde dolore illo porro nihil nam, magni officiis explicabo veritatis adipisci suscipit perferendis repudiandae quidem pariatur aspernatur!
      </div>
    </div>
  </div>
<?= $block->end() ?>
