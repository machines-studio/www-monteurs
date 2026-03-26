<?php
  $title ??= null;
  $label ??= null;
  $content = $content ?? $slots->content() ?? null;

  $attributes ??= [];
  $attributes['class'] = 'header ' . ($attributes['class'] ?? '');
?>

<header <?= attr($attributes) ?>>
  <?php if (trim($label ?? '')) : ?>
    <div class='label'><?= $label ?></div>
  <?php endif ?>

  <?php if (trim($title ?? '')) : ?>
    <h2 class='header__title'><?= kirbytext($title) ?></h2>
  <?php endif ?>

  <?php if (trim($content ?? '')) : ?>
    <div class='header__content prose'><?= $content ?></div>
  <?php endif ?>
</header>
