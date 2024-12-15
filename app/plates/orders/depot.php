<script type="text/javascript">
const link = '<?= $url->set('/v1/orders') ?>';

<?= $script = $form->script('orders')
  ->with('client_id')
  ->with('remarks')
  ->with('items', array())
  ->with('empty', false)
  ->with('loadError', false)
  ->with('id', null)
  ->with('delete', false)
  ->withError()
  ->withLoading() ?>

<?= $pagee->toObject('orders') ?>

<?= $depot->withInit($pagee->getPage()) ?>

<?= $depot->withClose()
  ->withScript($script)
  // ->hideModal('delete-order-modal')
  ->hideModal('order-detail-modal')
  ->resetField('client_id')
  ->resetField('error')
  ->resetField('id')
  ->resetField('remarks')
  ->resetField('loadError') ?>

<?= $depot->withLoad($pagee) ?>
</script>
