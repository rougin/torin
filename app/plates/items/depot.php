<script type="text/javascript">
<?= $script = $form->script('items')
  ->with('name')
  ->with('detail')
  ->with('items', array())
  ->with('empty', false)
  ->with('loadError', false)
  ->with('id', null)
  ->with('delete', false)
  ->withError()
  ->withLoading() ?>

<?= $pagee->toObject('items') ?>

<?= $depot->withInit($pagee->getPage()) ?>

<?= $depot->withClose()
  ->withScript($script)
  ->hideModal('delete-item-modal')
  ->hideModal('item-detail-modal')
  ->resetField('detail')
  ->resetField('error')
  ->resetField('id')
  ->resetField('name')
  ->resetField('loadError') ?>

<?= $depot->withEdit()
  ->addField('name')
  ->addField('detail')
  ->addField('id')
  ->showModal('item-detail-modal') ?>

<?= $depot->withLoad($pagee)
  ->setLink($url->set('/v1/items')) ?>

<?= $depot->withRemove()
  ->setLink($url->set('/v1/items')) ?>

<?= $depot->withStore()
  ->addField('name')
  ->addField('detail')
  ->setAlert('Item created!', 'Item successfully created.')
  ->setLink($url->set('/v1/items')) ?>

<?= $depot->withTrash()
  ->addField('name')
  ->addField('id')
  ->showModal('delete-item-modal') ?>

<?= $depot->withUpdate()
  ->addField('name')
  ->addField('detail')
  ->setAlert('Item updated!', 'Item successfully updated.')
  ->setLink($url->set('/v1/items')) ?>
</script>
