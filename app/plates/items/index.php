<?= $layout->load('main'); ?>

<?= $block->body() ?>
  <div class="mb-3">
    <?php echo $plate->add('navbar', compact('block', 'url')) ?>
  </div>

  <div class="container mb-3">
    <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga distinctio aut odit incidunt adipisci animi ipsum voluptatum repellat tempore quo culpa molestias totam ex commodi perspiciatis magni obcaecati id, omnis.</div>
  </div>
<?= $block->end() ?>
