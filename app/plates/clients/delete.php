<div class="modal fade" id="delete-client-modal" data-bs-backdrop="static" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header text-white bg-danger border-bottom-0">
      <div class="modal-title fs-5 fw-bold" id="client-detail-modal-label">Delete client?</div>
    </div>
    <div class="modal-body">
      <p class="mb-0">Are you sure that you want to delete the client <span class="fw-bold" x-text="name"></span>?</p>
      <?= $form->error('error.delete') ?>
    </div>
    <div class="modal-footer border-top-0 bg-light">
      <div class="me-auto">
        <div class="spinner-border align-middle text-danger" role="status" x-show="loading">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <?= $form->button('Cancel', 'btn btn-link text-secondary text-decoration-none')->with('@click', 'close')->disablesOn('loading') ?>
      <?= $form->button('Delete', 'btn btn-danger')->onClick('remove(id)')->disablesOn('loading') ?>
    </div>
  </div>
</div>
</div>
