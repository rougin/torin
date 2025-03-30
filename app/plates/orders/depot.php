<script type="text/javascript">
<?= $script = $form->script('orders')
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
  ->withError()
  ->withLoading() ?>

<?= $pagee->toObject('orders') ?>

<?= $depot->withInit($pagee->getPage())
  ->addSelect('ts_clients', '#clients', $url->set('/v1/clients/select'))
  ->addSelect('ts_items', '#items', $url->set('/v1/items/select')) ?>

<?= $depot->withClose()
  ->withScript($script)
  // ->hideModal('delete-order-modal')
  ->hideModal('order-detail-modal')
  ->resetField('client_id')
  ->resetField('error')
  ->resetField('id')
  ->resetField('remarks')
  ->resetField('loadError') ?>

<?= $depot->withLoad($pagee)
  ->setLink($url->set('/v1/orders')) ?>

<?= $depot->withStore()
  ->addField('client_id')
  ->addField('remarks')
  ->addField('type')
  ->addField('cart')->asArray()
  ->setAlert('Client created!', 'Client successfully created.')
  ->setLink($url->set('/v1/clients')) ?>

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

  if (last !== null)
  {
    this.cart[last].quantity += row.quantity;
  }
  else
  {
    this.cart.push(row);
  }

  this.ts_items.clear();

  this.quantity = null;
};
</script>
