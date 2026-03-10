<?php
  $slug ??= null;
  $parent ??= $page;

  if (!$slug) return;

  $label = $slug;
  foreach ($parent->categories()->toStructure() as $category) {
    if ($category->title()->slug() != $slug) continue;
    $label = $category->title();
    break;
  }

  echo Html::a(
    url($parent, ['params' => ['voir' => $slug]]),
    $label,
    [
      'class' => r(param('voir') == $slug, 'is-active')
    ]
  );
?>
