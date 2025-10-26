<?php echo $layout->load('main', compact('plate')); ?>

<?php echo $block->set('styles') ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/css/tom-select.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/css/tom-select.bootstrap5.min.css">
<?php echo $block->end() ?>

<?php echo $block->body() ?>
  <div x-data="orders" @orders.window="load($event.detail)">
    <div class="mb-3">
      <?php echo $plate->add('navbar', compact('block', 'url')) ?>
    </div>

    <div class="container mb-3">
      <div class="d-flex justify-content-between align-items-end">
        <div>
          <span class="fs-2 lh-1 fw-bold">Orders</span>
        </div>
        <div>
          <?php echo $form->button('Create New')->withClass('btn btn-secondary shadow-lg')
            ->with('data-bs-toggle', 'modal')->with('data-bs-target', '#order-detail-modal')
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

    <?php echo $plate->add('orders/delete', compact('form')) ?>
    <?php echo $plate->add('orders/detail', compact('form')) ?>
    <?php echo $plate->add('orders/status', compact('form')) ?>
  </div>
<?php echo $block->end() ?>

<?php echo $block->set('scripts') ?>
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/js/tom-select.complete.min.js"></script>
  <?php echo $plate->add('orders/depot', compact('depot', 'form', 'pagee', 'url')) ?>
<?php echo $block->end() ?>
