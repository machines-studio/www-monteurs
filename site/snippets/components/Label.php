<?php
  $item ??= null;
  if (!$item) return;

  $showDate ??= $item->showDate()->bool();
  $date = $item->date();
  $categories = $item->categories()->split();
?>

<aside class='label'>
  <?php if ($showDate && $date) : ?>
    <time class='label__time' datetime='<?= $date->toDate(option('date.formats.iso'))?>'>
      <?= $date->toDate(option('date.formats.full')) ?>
    </time>
  <?php endif ?>

  <?php if (count($categories)) : ?>
    <ul class='label__categories'>
      <?php foreach ($categories as $category) : ?>
        <li class='label__category'><?php snippet('html/category', [
          'slug' => $category,
          'parent' => $item->parent()
        ]) ?></li>
      <?php endforeach ?>
    </ul>
  <?php endif ?>
</aside>
