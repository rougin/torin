<script type="text/javascript">
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

<?= $depot->withLoad($pagee)
  ->setLink($url->set('/v1/clients')) ?>

<?= $depot->withRemove()
  ->setLink($url->set('/v1/clients')) ?>

<?= $depot->withStore()
  ->addField('name')
  ->addField('remarks')
  ->addField('type')
  ->setAlert('Client created!', 'Client successfully created.')
  ->setLink($url->set('/v1/clients')) ?>

<?= $depot->withTrash()
  ->addField('name')
  ->addField('id')
  ->showModal('delete-client-modal') ?>

<?= $depot->withUpdate()
  ->addField('name')
  ->addField('remarks')
  ->addField('type')
  ->setAlert('Client updated!', 'Client successfully updated.')
  ->setLink($url->set('/v1/clients')) ?>
</script>
