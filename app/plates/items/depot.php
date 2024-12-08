<script type="text/javascript">
const link = '<?= $url->set('/v1/items') ?>';

<?= $form->script('items')
  ->with('name')
  ->with('detail')
  ->with('items', array())
  ->with('empty', false)
  ->with('loadError', false)
  ->with('id', null)
  ->withError()
  ->withLoading() ?>

items.init = function ()
{
  this.load()
}

items.edit = function (item)
{
  const self = this

  self.name = item.name

  self.detail = item.detail

  self.id = item.id

  Modal.show('item-modal')
}

items.load = function ()
{
  const self = this

  self.loadError = false

  self.name = null

  self.detail = null

  self.loading = true

  let data = { p: <?= $page ?>, l: <?= $limit ?> }

  const search = new URLSearchParams(data)

  const query = search.toString()

  axios.get(link + '?' + query)
    .then(function (response)
    {
      const result = response.data

      if (result.items.length === 0)
      {
        self.empty = true
      }

      self.items = result.items
    })
    .catch(function (error)
    {
      self.loadError = true
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

items.update = function (id)
{
  const input = new FormData

  const self = this

  input.append('name', self.name)

  input.append('detail', self.detail)

  self.loading = true

  self.error = {}

  axios.put(link + '/' + id, input)
    .then(function (response)
    {
      Modal.hide('item-modal')

      Alert.success('Item updated!', 'Item successfully updated.')

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
