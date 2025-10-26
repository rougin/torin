<div class="modal fade" id="item-detail-modal" data-bs-backdrop="static" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header text-white border-bottom-0" :class="{ 'bg-primary': id, 'bg-secondary': !id }">
      <template x-if="id">
        <div class="modal-title fs-5 fw-bold" id="item-detail-modal-label">Update Item</div>
      </template>
      <template x-if="! id">
        <div class="modal-title fs-5 fw-bold" id="item-detail-modal-label">Create New Item</div>
      </template>
    </div>
    <div class="modal-body">
      <div class="mb-3">
        <?php echo $form->label('Name', 'form-label mb-0')->asRequired() ?>
        <?php echo $form->input('name', 'form-control')->asModel()->disablesOn('loading') ?>
        <?php echo $form->error('error.name') ?>
      </div>
      <div>
        <?php echo $form->label('Description', 'form-label mb-0')->asRequired() ?>
        <?php echo $form->input('detail', 'form-control')->asModel()->disablesOn('loading') ?>
        <?php echo $form->error('error.detail') ?>
      </div>
    </div>
    <div class="modal-footer border-top-0 bg-light">
      <div class="me-auto">
        <div class="spinner-border align-middle" :class="{ 'text-primary': id, 'text-secondary': !id }" role="status" x-show="loading">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <?php echo $form->button('Cancel', 'btn btn-link text-secondary text-decoration-none')->with('@click', 'close')->disablesOn('loading') ?>
      <template x-if="id">
        <?php echo $form->button('Update', 'btn btn-primary')->onClick('update(id)')->disablesOn('loading') ?>
      </template>
      <template x-if="! id">
        <?php echo $form->button('Create New', 'btn btn-secondary')->onClick('store')->disablesOn('loading') ?>
      </template>
    </div>
  </div>
</div>
</div>
