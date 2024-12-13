<script type="text/javascript">
const link = '<?= $url->set('/v1/clients') ?>';

<?= $script = $form->script('clients')
  ->with('name')
  ->with('remarks')
  ->with('type')
  ->with('items', array())
  ->with('empty', false)
  ->with('loadError', false)
  ->with('id', null)
  ->with('delete', false)
  ->withError()
  ->withLoading() ?>

<?= $pagee->toObject('clients') ?>

<?= $depot->withInit($pagee->getPage()) ?>

<?= $depot->withClose()
  ->withScript($script)
  ->hideModal('delete-client-modal')
  ->hideModal('client-detail-modal')
  ->resetField('remarks')
  ->resetField('error')
  ->resetField('id')
  ->resetField('name')
  ->resetField('loadError') ?>

<?= $depot->withEdit()
  ->addField('name')
  ->addField('remarks')
  ->addField('type')
  ->addField('id')
  ->showModal('client-detail-modal') ?>

<?= $depot->withLoad($pagee) ?>

<?= $depot->withRemove() ?>

<?= $depot->withStore()
  ->addField('name')
  ->addField('remarks')
  ->addField('type')
  ->setAlert('Client created!', 'Client successfully created.') ?>

<?= $depot->withTrash()
  ->addField('name')
  ->addField('id')
  ->showModal('delete-client-modal') ?>

<?= $depot->withUpdate()
  ->addField('name')
  ->addField('remarks')
  ->setAlert('Client updated!', 'Client successfully updated.') ?>
</script>
