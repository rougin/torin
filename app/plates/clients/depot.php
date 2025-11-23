<script type="text/javascript">
<?php echo $script = $form->script('clients')
  ->with('name', null)
  ->with('remarks', null)
  ->with('type', null)
  ->with('items', array())
  ->with('empty', false)
  ->with('loadError', false)
  ->with('id', null)
  ->with('delete', false)
  ->withError()
  ->withLoading() ?>

<?php echo $pagee->toObject('clients') ?>

<?php echo $depot->withInit($pagee->getPage()) ?>

<?php echo $depot->withClose()
  ->hideModal('delete-client-modal')
  ->hideModal('client-detail-modal')
  ->setDefaults($script->getFields())
  ->resetField('remarks')
  ->resetField('error')
  ->resetField('id')
  ->resetField('name')
  ->resetField('loadError') ?>

<?php echo $depot->withEdit()
  ->addField('name')
  ->addField('remarks')
  ->addField('type')
  ->addField('id')
  ->showModal('client-detail-modal') ?>

<?php echo $depot->withLoad()
  ->setLink($url->set('/v1/clients')) ?>

<?php echo $depot->withRemove()
  ->setLink($url->set('/v1/clients')) ?>

<?php echo $depot->withStore()
  ->addField('name')
  ->addField('remarks')
  ->addField('type')
  ->setAlert('Client created!', 'Client successfully created.')
  ->setLink($url->set('/v1/clients')) ?>

<?php echo $depot->withTrash()
  ->addField('name')
  ->addField('id')
  ->showModal('delete-client-modal') ?>

<?php echo $depot->withUpdate()
  ->addField('name')
  ->addField('remarks')
  ->addField('type')
  ->setAlert('Client updated!', 'Client successfully updated.')
  ->setLink($url->set('/v1/clients')) ?>
</script>
