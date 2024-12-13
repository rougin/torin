<script type="text/javascript">
const link = '<?= $url->set('/v1/clients') ?>';

<?= $script = $form->script('clients')
  ->with('name')
  ->with('detail')
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
  ->resetField('detail')
  ->resetField('error')
  ->resetField('id')
  ->resetField('name')
  ->resetField('loadError') ?>

<?= $depot->withEdit()
  ->addField('name')
  ->addField('detail')
  ->addField('type')
  ->addField('id')
  ->showModal('client-detail-modal') ?>

<?= $depot->withLoad($pagee) ?>

<?= $depot->withRemove() ?>

<?= $depot->withStore()
  ->addField('name')
  ->addField('detail')
  ->addField('type')
  ->setAlert('Client created!', 'Client successfully created.') ?>

<?= $depot->withTrash()
  ->addField('name')
  ->addField('id')
  ->showModal('delete-client-modal') ?>

<?= $depot->withUpdate()
  ->addField('name')
  ->addField('detail')
  ->setAlert('Client updated!', 'Client successfully updated.') ?>
</script>
