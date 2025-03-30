<div class="modal fade" id="order-detail-modal" data-bs-backdrop="static" tabindex="-1">
<div class="modal-dialog modal-dialog-centered modal-scrollable">
  <div class="modal-content">
    <div class="modal-header text-white border-bottom-0" :class="{ 'bg-primary': id, 'bg-secondary': !id }">
      <template x-if="id">
        <div class="modal-title fs-5 fw-bold" id="order-detail-modal-label">Update Order Details</div>
      </template>
      <template x-if="! id">
        <div class="modal-title fs-5 fw-bold" id="order-detail-modal-label">Create New Order</div>
      </template>
    </div>
    <div class="modal-body">
      <div class="row mb-3">
        <div class="col-sm-8">
          <?= $form->label('Client Name', 'form-label mb-0')->asRequired() ?>
          <?= $form->select('client_id', [], 'form-select')->withId('clients')->asModel()->disablesOn('loading') ?>
          <?= $form->error('error.client_id') ?>
        </div>
        <div class="col-sm-4">
          <?= $form->label('Order Type', 'form-label mb-0')->asRequired() ?>
          <?= $form->select('type', ['Sale', 'Purchase', 'Transfer'], 'form-select')->withId('type')->asModel()->disablesOn('loading') ?>
          <?= $form->error('error.type') ?>
        </div>
      </div>
      <hr>
      <div class="mb-3">
        <div class="row">
          <div class="col-sm-6">
            <?= $form->label('Item to add', 'form-label mb-0 small') ?>
            <?= $form->select('item_id', [], 'form-select')->withId('items')->asModel()->disablesOn('loading') ?>
          </div>
          <div class="col-sm-3">
            <?= $form->label('Quantity', 'form-label mb-0 small') ?>
            <?= $form->input('quantity', 'form-control')->asNumber()->asModel()->disablesOn('loading') ?>
          </div>
          <div class="col-sm-3 align-self-end mb-1">
            <?= $form->button('Add to order', 'btn btn-sm btn-secondary')->onClick('add')->disablesOn('loading') ?>
          </div>
        </div>
      </div>
      <div class="mb-3">
        <table class="table">
          <thead>
            <tr class="fw-bold small">
              <td width="80%">Name of Item</td>
              <td width="20%">Quantity</td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            <template x-for="item in cart">
              <tr>
                <td x-text="item.name"></td>
                <td x-text="item.quantity"></td>
                <td></td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-12">
          <?= $form->label('Remarks', 'form-label mb-0') ?>
          <?= $form->input('remarks', 'form-control')->asModel()->disablesOn('loading') ?>
          <?= $form->error('error.remarks') ?>
        </div>
      </div>
    </div>
    <div class="modal-footer border-top-0 bg-light">
      <div class="me-auto">
        <div class="spinner-border align-middle" :class="{ 'text-primary': id, 'text-secondary': !id }" role="status" x-show="loading">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <?= $form->button('Cancel', 'btn btn-link text-secondary text-decoration-none')->with('@click', 'close')->disablesOn('loading') ?>
      <template x-if="id">
        <?= $form->button('Update Details', 'btn btn-primary')->onClick('update(id)')->disablesOn('loading') ?>
      </template>
      <template x-if="! id">
        <?= $form->button('Create New', 'btn btn-secondary')->onClick('store')->disablesOn('loading') ?>
      </template>
    </div>
  </div>
</div>
</div>
