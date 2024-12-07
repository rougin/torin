<script>
const link = '<?= $url->set('/v1/items') ?>';

<?= $form->script('items')
  ->with('name')
  ->with('detail')
  ->with('items', array())
  ->withError()
  ->withLoading() ?>

items.init = function ()
{
  this.load()
}

items.load = function ()
{
  const self = this

  self.loading = true

  axios.get(link)
    .then(function (response)
    {
      const result = response.data

      console.log(result.items)

      self.items = result.items
    })
    .catch(function (error)
    {
      console.log(error)
    })
    .finally(function ()
    {
      self.loading = false
    })
}

items.store = function ()
{
  const input = new FormData

  const self = this

  input.append('name', self.name)

  input.append('detail', self.detail)

  self.loading = true

  self.error = {}

  axios.post(link, input)
    .then(function (response)
    {
      Modal.hide('item-modal')

      Alert.success('Item created!', 'Item successfully created.')

      self.load()
    })
    .catch(function (error)
    {
      self.error = error.response.data
    })
    .finally(function ()
    {
      self.loading = false
    })
}
</script>