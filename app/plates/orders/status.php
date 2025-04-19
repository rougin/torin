<div class="modal fade" id="mark-order-modal" data-bs-backdrop="static" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header bg-warning border-bottom-0">
      <div class="modal-title fs-5 fw-bold" id="order-detail-modal-label">Changer order status?</div>
    </div>
    <div class="modal-body">
      <p>Are you sure that you want to change the order status to <span class="fw-bold text-uppercase" x-text="status === STATUS_COMPLETED ? 'Fulfilled' : (status === STATUS_CANCELLED ? 'Cancelled' : 'Pending')"></span>?</p>
      <?= $form->error('error.mark') ?>
    </div>
    <div class="modal-footer border-top-0 bg-light">
      <div class="me-auto">
        <div class="spinner-border align-middle text-warning" role="status" x-show="loading">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <?= $form->button('Cancel', 'btn btn-link text-secondary text-decoration-none')->with('@click', 'close')->disablesOn('loading') ?>
      <?= $form->button('Change Status', 'btn btn-warning')->onClick('change(id, status)')->disablesOn('loading') ?>
    </div>
  </div>
</div>
</div>
