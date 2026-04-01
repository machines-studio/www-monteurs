<?php

namespace LMA;
use \Kirby;
use \Kirby\Toolkit\Str;

Kirby::plugin('lma/toc', [
  'options' => [
    'headlines' => 'h1'
  ],

  'hooks' => [
    'kirbytext:after' => function ($text) {
      $headlines = option('lma.toc.headlines');
      $headlinesPattern = is_array($headlines) ? implode('|', $headlines) : $headlines;
      return preg_replace_callback('!<(' . $headlinesPattern . ')>(.*?)</\\1>!s', function ($match) {
        $id = Str::slug(Str::unhtml($match[2]));
        return '<' . $match[1] . ' id="' . $id . '">' . $match[2] . '</' . $match[1] . '>';
      }, $text);
    }
  ],

  'fieldMethods' => [
    'toToc' => function ($field, ?string $headlines = null) : string {
      $blueprint = $field->model()->blueprint();
      $type = $blueprint->field($field->key())['type'] ?? null;
      $value = ($type === 'blocks'
        ? $field->toBlocks()->toHtml()
        : $field->value
      ) ?? '';

      $headlines ??= option('lma.toc.headlines');
      $headlinesPattern = is_array($headlines) ? implode('|', $headlines) : $headlines;
      preg_match_all('!<(' . $headlinesPattern . ')\b[^>]*>(.*?)</\1>!si', $value, $matches, PREG_SET_ORDER);

      $toc = '';
      $currentLevel = 1;
      foreach ($matches as $match) {
        $level = intval(substr($match[1], 1));
        $currentLevel ??= $level;

        if ($level > $currentLevel) $toc .= str_repeat('<ul>', $level - $currentLevel);
        if ($level < $currentLevel) $toc .= str_repeat('</ul>', $currentLevel - $level);

        $text = $match[2];
        $slug = Str::slug(Str::unhtml($match[2]));
        $toc .= "<li><a href='#$slug'>$text</a></li>";

        $currentLevel = $level;
      }

      $toc .= '</ul>';

      return $toc;
    }
  ]
]);
