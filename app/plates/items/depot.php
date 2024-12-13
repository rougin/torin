<script type="text/javascript">
const link = '<?= $url->set('/v1/items') ?>';

<?= $form->script('items')
  ->with('name')
  ->with('detail')
  ->with('items', array())
  ->with('empty', false)
  ->with('loadError', false)
  ->with('id', null)
  ->with('delete', false)
  ->withError()
  ->withLoading() ?>

items.pagee = <?= $pagee->getObject('items') ?>

items.init = function ()
{
  this.load(<?= $pagee->getPage() ?>)
}

items.close = function ()
{
  const self = this

  Modal.hide('delete-item-modal')

  Modal.hide('item-detail-modal')

  setTimeout(() =>
  {
    self.detail = null

    self.error = {}

    self.id = null

    self.loadError = false

    self.name = null
  }, 1000)
}

items.edit = function (item)
{
  const self = this

  self.name = item.name

  self.detail = item.detail

  self.id = item.id

  Modal.show('item-detail-modal')
}

items.load = function (page)
{
  const self = this

  self.loading = true

  let data = { <?= $pagee->getPageKey() ?>: page }
  self.pagee.page = page

  data.<?= $pagee->getLimitKey() ?> = <?= $pagee->getLimit() ?>

  const search = new URLSearchParams(data)

  axios.get(link + '?' + search.toString())
    .then(function (response)
    {
      const result = response.data

      if (result.items.length === 0)
      {
        self.empty = true
      }

      self.pagee.limit = result.limit
      self.pagee.pages = result.pages
      self.pagee.total = result.total

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

items.remove = function (id)
{
  const input = new FormData

  const self = this

  self.loading = true

  self.error = {}

  axios.delete(link + '/' + id, input)
    .then(function (response)
    {
      self.close()

      Alert.success('Item deleted!', 'Item successfully deleted.')

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
      self.close()

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

items.trash = function (item)
{
  const self = this

  self.name = item.name

  self.id = item.id

  Modal.show('delete-item-modal')
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
      self.close()

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
