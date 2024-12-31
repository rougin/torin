<script type="text/javascript">
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

<?= $depot->withLoad($pagee)
  ->setLink($url->set('/v1/orders')) ?>

axios.get('<?= $url->set('/v1/clients/select') ?>')
  .then(response =>
  {
    let config = { options: response.data };

    config.create = false;
    config.plugins = [ 'dropdown_input' ];
    config.labelField = 'label';
    config.searchField = 'label';
    config.sortField = 'label';
    config.valueField = 'value';

    setTimeout(() =>
    {
      new TomSelect('#clients', config);
    }, 1000);
  });
</script>
