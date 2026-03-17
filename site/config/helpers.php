<?php

// Config helper to quickly define date.formats options
function intl (string $pattern, ?string $locale = 'fr_FR') {
  return new IntlDateFormatter($locale, IntlDateFormatter::FULL, IntlDateFormatter::SHORT, null, IntlDateFormatter::GREGORIAN, $pattern);
}

// Config helper to add a Page as a panel.menu entry
function menu ($kirby, string $uid, string $icon = 'page') {
  $page = $kirby->page($uid);
  if (!$page) return;

  return [
    'icon' => $page->blueprint()->icon() ?? $icon,
    'label' => $page->title(),
    'link' => $page->panel()->url(),
    'current' => function (string $current) use ($uid) : bool {
      $path = Kirby\Cms\App::instance()->path();
      return Str::contains($path, "pages/$uid");
    }
  ];
}

// Dump to PHP console
function console_dump (mixed $value, bool $clear = true) {
  if ($clear) error_log("\e[H\e[J");
  error_log(print_r($value, true));
}

// Build URL with query parameters
function buildParamURL ($arr) {
  $params = array_merge(params(), $arr);
  return url('./' . url::paramsToString($params));
}

// Get article year from date field
function getArticleYear ($article) {
  return $article->date('%Y');
}

// Get top-level parent page
function getTopLevelPage ($page) {
  if ($page->depth() === 1) return $page;
  $parents = $page->parents();
  return $parents->last();
}

// Remove protocol from URL for display
function beautifyUrl ($url) {
  return preg_replace('(^https?://)', '', $url);
}

// Convert attachment structure to link array
function attachmentToLink ($page, $attachment) {
  // Allow passing $attachment as simple ['title' => '', 'url' => ''] array
  if (is_array($attachment)) return $attachment;

  $p = $attachment->page()->isNotEmpty() ? site()->find($attachment->page()) : null;
  $url = $attachment->url()->isNotEmpty() ? $attachment->url() : null;
  $file = $attachment->file()->isNotEmpty() ? $page->file($attachment->file()) : null;

  if ($file) $url = $file->url();
  if ($p) $url = $p->url();
  if (!$url) return null;

  $title = $attachment->text()->isNotEmpty() ? $attachment->text()->html() : null;
  if (!$title) {
    if ($file) $title = $file->filename();
    else $title = beautifyUrl($url);
  }

  return compact('title', 'url');
}

// Get category title from slug
function unslug_category ($listTemplate, $category_id) {
  $page = site()->index()->filterBy('intendedTemplate', $listTemplate)->first();
  if (!$page) return null;

  $categories = $page->categories()->toStructure();
  foreach ($categories as $category) {
    if (Str::slug($category->title()) === $category_id) {
      return $category->title();
    }
  }

  return null;
}
