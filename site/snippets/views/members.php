<?php
  snippet('views/articles', [
    'pages' => $page->children()->listed()->sortBy('date', 'DESC')
  ], slots: true);
    slot('sidebar');
      snippet('html/link', page('annoncer-une-actualite'));
    endslot();
  endsnippet();
