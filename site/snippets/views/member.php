<?php
  snippet('views/default', ['showDate' => true], slots: true);
    slot('sidebar');
      snippet('html/link', page('annoncer-une-actualite'));
    endslot();
  endsnippet();
