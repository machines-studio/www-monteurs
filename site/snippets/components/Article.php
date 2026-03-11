<?php
  $sidebar ??= $slots->sidebar() ?? null;
  $content ??= $slots->content() ?? null;

  $attributes ??= [];
  $attributes['class'] = 'article ' . ($attributes['class'] ?? '');
?>

<section <?= attr($attributes) ?>>
  <aside class='article__sidebar'>
    <?= $sidebar ?>
  </aside>

  <article class='article__content'>
    <?= $content ?>
  </article>
</section>
