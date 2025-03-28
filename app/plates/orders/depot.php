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
  ->setAlert('Client created!', 'Client successfully created.')
  ->setLink($url->set('/v1/clients')) ?>

orders.add = function ()
{
  const opt = this.ts_items.getOption(this.item_id);

  if (! opt) return;

  let item = {};
  item.id = parseInt(this.item_id);
  item.name = opt.textContent;
  item.quantity = this.quantity;

  this.cart.push(item);

  this.ts_items.clear();

  this.quantity = null;
};
</script>
