<div class="modal fade" id="cuel-alert-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div id="cuel-alert-modal-header">
        <span class="modal-title fs-5 fw-bold" id="cuel-alert-modal-title"></span>
      </div>
      <div class="modal-body" id="cuel-alert-modal-body"></div>
      <div class="modal-footer border-top-0 bg-light">
        <div class="me-auto"></div>
        <button type="button" class="btn btn-link text-secondary text-decoration-none" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
const Modal =
{
  get(id)
  {
    const el = document.getElementById(id)

    return bootstrap.Modal.getOrCreateInstance(el)
  },

  hide(id)
  {
    return this.get(id).hide()
  },

  show(id)
  {
    return this.get(id).show()
  },

  toggle(id)
  {
    return this.get(id).toggle()
  },
}
</script>
