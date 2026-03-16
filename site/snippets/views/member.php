<?php
  snippet('views/default', [], slots: true);
    slot('sidebar');
      snippet('html/link', page('annoncer-une-actualite'));
    endslot();
  endsnippet();
