<?php
  snippet('views/pages', [
    'pages' => $page->children()->listed()->sortBy('date', 'DESC'),
    'showDate' => true,
    'archives' => true
  ], slots: true);
    slot('sidebar');
      snippet('html/link', page('annoncer-une-actualite'));
    endslot();
  endsnippet();
