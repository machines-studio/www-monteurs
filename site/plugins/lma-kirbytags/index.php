<?php

namespace LMA;
use \Kirby;
use \Kirby\Text\KirbyTag;

$imageTag = Kirbytag::$types['image'];

Kirby::plugin('lma/kirbytags', [
  'tags' => [
    'image' => [
      'attr' => [
        ...$imageTag['attr'],
        'zoomable'
      ],

      'html' => function (Kirbytag $tag) : string {
        $kirby = $tag->kirby();
        $html = snippet('html/image', [
          'image' => $tag->file($tag->value),
          'photoswipe' => true
        ], true);

        return preg_replace('/\s+/', ' ', $html);
      }
    ]
  ]
]);
