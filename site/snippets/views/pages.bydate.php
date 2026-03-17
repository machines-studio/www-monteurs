<?php
  snippet('views/pages', [
    'pages' => $page->children()->listed()->sortBy('date', 'DESC'),
    'archives' => true
  ]);
