<?php
  $sidebar ??= $slots->sidebar() ?? null;
  $label ??= $slots->label() ?? null;
  $content ??= $slots->content() ?? null;

  $attributes ??= [];
  $attributes['class'] = 'article ' . ($attributes['class'] ?? '');
?>

<section <?= attr($attributes) ?>>
  <aside class='article__sidebar'>
    <?= $sidebar ?>
  </aside>

  <article class='article__content'>
    <?php if ($label) : ?>
      <header>
        <div class='label'><?= $label ?></div>
      </header>
    <?php endif ?>

    <?= $content ?>
  </article>
</section>
