<?= $layout->load('main', compact('plate')); ?>

<?= $block->body() ?>
  <div x-data="items">
    <div class="mb-3">
      <?= $plate->add('navbar', compact('block', 'url')) ?>
    </div>

    <div class="container mb-3">
      <span class="fs-1">Items</span>
    </div>

    <div class="container mb-3">
      <?= $form->button('Create New')->withClass('btn btn-primary shadow-lg')
        ->with('data-bs-toggle', 'modal')->with('data-bs-target', '#item-detail-modal')
        ->disablesOn('loading') ?>
    </div>

    <div class="container mb-3">
      <div class="card shadow-lg">
        <div class="card-body">
          <div><?= $table ?></div>
        </div>
      </div>
    </div>

    <?= $plate->add('items.delete', compact('form')) ?>
    <?= $plate->add('items.detail', compact('form')) ?>
  </div>
<?= $block->end() ?>

<?= $block->set('scripts') ?>
  <?= $plate->add('items.depot', compact('form', 'url', 'page', 'limit')) ?>
<?= $block->end() ?>
