<script type="text/javascript">
<?php echo $script = $form->script('items')
  ->with('name')
  ->with('detail')
  ->with('items', array())
  ->with('empty', false)
  ->with('loadError', false)
  ->with('id', null)
  ->with('delete', false)
  ->withError()
  ->withLoading() ?>

<?php echo $pagee->toObject('items') ?>

<?php echo $depot->withInit($pagee->getPage()) ?>

<?php echo $depot->withClose()
  ->withScript($script)
  ->hideModal('delete-item-modal')
  ->hideModal('item-detail-modal')
  ->resetField('detail')
  ->resetField('error')
  ->resetField('id')
  ->resetField('name')
  ->resetField('loadError') ?>

<?php echo $depot->withEdit()
  ->addField('name')
  ->addField('detail')
  ->addField('id')
  ->showModal('item-detail-modal') ?>

<?php echo $depot->withLoad()
  ->setLink($url->set('/v1/items')) ?>

<?php echo $depot->withRemove()
  ->setLink($url->set('/v1/items')) ?>

<?php echo $depot->withStore()
  ->addField('name')
  ->addField('detail')
  ->setAlert('Item created!', 'Item successfully created.')
  ->setLink($url->set('/v1/items')) ?>

<?php echo $depot->withTrash()
  ->addField('name')
  ->addField('id')
  ->showModal('delete-item-modal') ?>

<?php echo $depot->withUpdate()
  ->addField('name')
  ->addField('detail')
  ->setAlert('Item updated!', 'Item successfully updated.')
  ->setLink($url->set('/v1/items')) ?>
</script>
