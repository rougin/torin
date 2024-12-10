<div class="modal fade" id="item-detail-modal" data-bs-backdrop="static" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header text-white bg-primary border-bottom-0">
      <template x-if="id">
        <div class="modal-title fs-5 fw-bold" id="item-detail-modal-label">Update Item Details</div>
      </template>
      <template x-if="! id">
        <div class="modal-title fs-5 fw-bold" id="item-detail-modal-label">Create New Item</div>
      </template>
    </div>
    <div class="modal-body">
      <div class="mb-3">
        <?= $form->label('Name', 'form-label mb-0')->asRequired() ?>
        <?= $form->input('name', 'form-control')->asModel()->disablesOn('loading') ?>
        <?= $form->error('error.name') ?>
      </div>
      <div>
        <?= $form->label('Description', 'form-label mb-0')->asRequired() ?>
        <?= $form->input('detail', 'form-control')->asModel()->disablesOn('loading') ?>
        <?= $form->error('error.detail') ?>
      </div>
    </div>
    <div class="modal-footer border-top-0 bg-light">
      <div class="me-auto">
        <div class="spinner-border align-middle text-primary" role="status" x-show="loading">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <?= $form->button('Cancel', 'btn btn-link text-secondary text-decoration-none')->with('@click', 'close')->disablesOn('loading') ?>
      <template x-if="id">
        <?= $form->button('Update Details', 'btn btn-primary')->onClick('update(id)')->disablesOn('loading') ?>
      </template>
      <template x-if="! id">
        <?= $form->button('Create New', 'btn btn-primary')->onClick('store')->disablesOn('loading') ?>
      </template>
    </div>
  </div>
</div>
</div>
