<?php
  snippet('views/articles', [
    'pages' => $page->children()->listed()->sortBy('date', 'DESC'),
    'archives' => true
  ]);
