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
  ->withError()
  ->withLoading() ?>

<?= $pagee->toObject('orders') ?>

<?= $depot->withInit($pagee->getPage())
  ->addSelect('#clients', $url->set('/v1/clients/select')) ?>

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
</script>
