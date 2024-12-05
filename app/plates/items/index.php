<?= $layout->load('main'); ?>

<?= $block->body() ?>
  <div class="mb-5">
    <?= $plate->add('navbar', compact('block', 'url')) ?>
  </div>

  <div class="container mb-3">
    <?= $form->button('Create New')->withClass('btn btn-primary shadow-lg')
      ->with('data-bs-toggle', 'modal')->with('data-bs-target', '#item-modal') ?>
  </div>

  <div class="container mb-3">
    <div class="card shadow-lg">
      <div class="card-body">
        <div><?= $table ?></div>
      </div>
    </div>
  </div>

  <?= $plate->add('items.modal', compact('form')) ?>
<?= $block->end() ?>

<?= $block->set('scripts') ?>
  <script>
    <?= $form->script('items')
      ->with('name')
      ->with('detail')
      ->withError()
      ->withLoading() ?>

    items.store = function ()
    {
      this.loading = true

      setTimeout(() =>
      {
        this.loading = false
      }, 1000)
    }
  </script>
<?= $block->end() ?>
