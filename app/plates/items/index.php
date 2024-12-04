<?= $layout->load('main'); ?>

<?= $block->body() ?>
  <div class="mb-5">
    <?= $plate->add('navbar', compact('block', 'url')) ?>
  </div>

  <div class="container mb-3">
    <?= $form->buttonLink('Create New', $url->set('items/create'), 'btn btn-primary') ?>
  </div>

  <div class="container mb-3">
    <div class="card shadow-lg">
      <div class="card-body">
        <div><?= $table ?></div>
      </div>
    </div>
  </div>
<?= $block->end() ?>
