<?= $layout->load('main', compact('plate')); ?>

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
    const link = '<?= $url->set('/v1/items') ?>';

    <?= $form->script('items')
      ->with('name')
      ->with('detail')
      ->withError()
      ->withLoading() ?>

    items.store = function ()
    {
      const input = new FormData

      const self = this

      input.append('name', self.name)

      input.append('detail', self.detail)

      self.loading = true

      self.error = {}

      axios.post(link, input)
        .then(function (response)
        {
          Modal.hide('item-modal')

          Alert.success('Item created!', 'Item successfully created.')
        })
        .catch(function (error)
        {
          self.error = error.response.data
        })
        .finally(function ()
        {
          self.loading = false
        })
    }
  </script>
<?= $block->end() ?>
