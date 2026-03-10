<?php

  echo page('actualites')
    ->children()
    ->visible()
    ->flip()
    ->limit(10)
    ->feed([
      'title' => $page->title(),
      'description' => $page->text(),
      'link' => 'actualites',
    ]);
