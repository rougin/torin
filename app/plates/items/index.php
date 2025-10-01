<?= $layout->load('main', compact('plate')); ?>

<?= $block->body() ?>
  <div x-data="items" @items.window="load($event.detail)">
    <div class="mb-3">
      <?= $plate->add('navbar', compact('block', 'url')) ?>
    </div>

    <div class="container mb-3">
      <div class="d-flex justify-content-between align-items-end">
        <div>
          <span class="fs-2 lh-1 fw-bold">Items</span>
        </div>
        <div>
          <?= $form->button('Create New')->withClass('btn btn-secondary shadow-lg')
            ->with('data-bs-toggle', 'modal')->with('data-bs-target', '#item-detail-modal')
            ->disablesOn('loading') ?>
        </div>
      </div>
      <div class="text-secondary">
        <hr>
      </div>
    </div>

    <div class="container mb-3">
      <div class="card shadow-lg">
        <div class="card-body">
          <div><?= $table ?></div>
        </div>
      </div>
      <div class="mt-3">
        <?= $pagee ?>
      </div>
    </div>

    <?= $plate->add('items/delete', compact('form')) ?>
    <?= $plate->add('items/detail', compact('form')) ?>
  </div>
<?= $block->end() ?>

<?= $block->set('scripts') ?>
  <?= $plate->add('items/depot', compact('depot', 'form', 'pagee', 'url')) ?>
<?= $block->end() ?>
