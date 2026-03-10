<?php
  $item ??= null;
  if (!$item) return;

  $date = $item->showDate()->bool() ? $item->date() : null;
?>

<aside class='label'>
  <?php if ($date) : ?>
    <time class='label__time' datetime='<?= $date->toDate(option('date.formats.iso'))?>'>
      <?= $date->toDate(option('date.formats.full')) ?>
    </time>
  <?php endif ?>

  <ul class='label__categories'>
    <?php foreach ($item->categories()->split() as $category) : ?>
      <li class='label__category'>
        <?php snippet('html/category', [
          'slug' => $category,
          'parent' => $item->parent()
        ]) ?>
      </li>
    <?php endforeach ?>
  </ul>
</aside>
