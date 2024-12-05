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
