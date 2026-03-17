<blockquote class='prose'>
  <?= $block->text() ?>
  <?php if ($block->citation()->isNotEmpty()): ?>
  <footer>
    <?= $block->citation() ?>
  </footer>
  <?php endif ?>
</blockquote>
