<?php echo $layout->load('main', compact('plate')) ?>

<?php echo $block->body() ?>
  <div x-data="clients" @clients.window="load($event.detail)">
    <div class="mb-3">
      <?php echo $plate->add('navbar', compact('block', 'url')) ?>
    </div>

    <div class="container mb-3">
      <div class="d-flex justify-content-between align-items-end">
        <div>
          <span class="fs-2 lh-1 fw-bold">Clients</span>
        </div>
        <div>
          <?php echo $form->button('Create New')->withClass('btn btn-secondary shadow-lg')
            ->with('data-bs-toggle', 'modal')->with('data-bs-target', '#client-detail-modal')
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
          <div><?php echo $table ?></div>
        </div>
      </div>
      <div class="mt-3">
        <?php echo $pagee ?>
      </div>
    </div>

    <?php echo $plate->add('clients/delete', compact('form')) ?>
    <?php echo $plate->add('clients/detail', compact('form')) ?>
<?php echo $block->end() ?>

<?php echo $block->set('scripts') ?>
  <?php echo $plate->add('clients/depot', compact('depot', 'form', 'pagee', 'url')) ?>
<?php echo $block->end() ?>
