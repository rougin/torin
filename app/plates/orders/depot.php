<script type="text/javascript">
<?= $script = $form->script('orders')
  ->with('STATUS_CANCELLED', 2)
  ->with('STATUS_PENDING', 0)
  ->with('STATUS_COMPLETED', 1)
  ->with('TYPE_SALE', 0)
  ->with('TYPE_PURCHASE', 1)
  ->with('TYPE_TRANSFER', 2)
  ->with('client_id')
  ->with('type')
  ->with('remarks')
  ->with('items', array())
  ->with('empty', false)
  ->with('loadError', false)
  ->with('id', null)
  ->with('delete', false)
  ->with('item_id', null)
  ->with('quantity', null)
  ->with('cart', array())
  ->with('code', null)
  ->with('status', null)
  ->withError()
  ->withLoading() ?>

<?= $pagee->toObject('orders') ?>

<?= $depot->withInit($pagee->getPage())
  ->addSelect('ts_clients', '#clients', $url->set('/v1/clients/select'))
  ->addSelect('ts_items', '#items', $url->set('/v1/items/select')) ?>

<?= $depot->withClose()
  ->withScript($script)
  ->hideModal('delete-order-modal')
  ->hideModal('mark-order-modal')
  ->hideModal('order-detail-modal')
  ->resetField('client_id')
  ->resetField('error')
  ->resetField('id')
  ->resetField('remarks')
  ->resetField('loadError') ?>

<?= $depot->withLoad($pagee)
  ->setLink($url->set('/v1/orders')) ?>

<?= $depot->withModal('mark')
  ->addField('status')
  ->addField('id')
  ->showModal('mark-order-modal') ?>

<?= $depot->withRemove()
  ->setLink($url->set('/v1/orders')) ?>

<?= $depot->withStore()
  ->addField('client_id')
  ->addField('remarks')
  ->addField('type')
  ->addField('cart')->asArray()
  ->setAlert('Client created!', 'Client successfully created.')
  ->setLink($url->set('/v1/orders')) ?>

<?= $depot->withTrash()
  ->addField('code')
  ->addField('id')
  ->showModal('delete-order-modal') ?>

orders.add = function ()
{
  const opt = this.ts_items.getOption(this.item_id);

  if (! opt) return;

  let row = { id: parseInt(this.item_id) };
  row.name = opt.textContent;
  row.quantity = parseInt(this.quantity);

  let last = null;

  this.cart.forEach(function (item, index)
  {
    if (item.id === row.id)
    {
      last = index;
    }
  });

  this.loading = true;

  this.error = {};

  const data = new FormData;

  data.append('type', this.type);
  data.append('quantity', row.quantity);
  data.append('item_id', row.id);

  const self = this;

  axios.post('/v1/orders/check', data)
    .then(function ()
    {
      if (last === null)
      {
        self.cart.push(row);

        last = 0;
      }

      self.cart[last].quantity += row.quantity;

      self.ts_items.clear();

      self.quantity = null;
    })
    .catch(function (error)
    {
      self.error.item_id = error.response.data;
    })
    .finally(function ()
    {
      self.loading = false;
    });
};
</script>
