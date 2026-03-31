<?php
  /**
   * Output a link from a page or an array
   * snippet('html/link', $page);
   * snippet('html/link', ['url' => 'https://example.com', 'title' => 'Example', 'attributes' => []]);
   */

  $link ??= $item ?? null; // $link contains the whole object passed to a snippet

  // Handle Kirby uuid representations
  if ($link instanceof \Kirby\Content\Field && $link->value) {
    if (str_starts_with($link->value, 'page://')) $link = $link->toPage();
    else if (str_starts_with($link->value, 'file://')) $link = $link->toFile();
  }

  if ($link instanceof \Kirby\Cms\Page) {
    echo Html::a($link->url(), $link->title(), [
      'class' => r($link->isOpen() || $link->isActive(), 'is-active'),
      'target' => Str::startsWith($link->url(), $site->url())
        ? null
        : (
          Str::startsWith($link->url(), '#')
            ? null
            : '_blank'
          )
    ]);
  } else if ($link instanceof \Kirby\Cms\File) {
    echo Html::a($link->url(), $text ?? tt('link.download', ['filename' => $link->nicename()->or($link->filename())]), [
      'download' => $link->filename()
    ]);
  } else {
    $url ??= $link;
    if (!trim($url ?? '')) return

    $text ??= $url ?? null;
    $active ??= false;
    $escape ??= true;

    $attributes ??= [];
    if ($active) $attributes['class'] = ($attributes['class'] ?? '') . ' is-active';
    if (!isset($attributes['target']) && !Str::startsWith($url, $site->url()) && !Str::startsWith($url, '#')) $attributes['target'] = '_blank';

    echo Html::a($url, [$text ?? $url], $attributes);
  }
?>
