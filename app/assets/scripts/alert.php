<script type="text/javascript">
const Alert =
{
  danger(title, text)
  {
    return this.show(title, text, 'bg-danger text-white')
  },

  info(title, text)
  {
    return this.show(title, text, 'bg-info text-white')
  },

  primary(title, text)
  {
    return this.show(title, text, 'bg-primary text-white')
  },

  secondary(title, text)
  {
    return this.show(title, text, 'bg-secondary text-white')
  },

  show(title, text, style)
  {
    const prefix = 'cuel-alert-modal'

    const header = document.getElementById(prefix + '-header')
    header.className = 'modal-header border-bottom-0 ' + style

    const name = document.getElementById(prefix + '-title')
    name.innerHTML = title

    const body = document.getElementById(prefix + '-body')
    body.innerHTML = text

    Modal.show('cuel-alert-modal')
  },

  success(title, text)
  {
    return this.show(title, text, 'bg-success text-white')
  },

  warning(title, text)
  {
    return this.show(title, text, 'bg-warning')
  },
}
</script>
