<?php

use Kirby;
use Kirby\Cms\Page;
use Kirby\Content\Field;

class ArticlePage extends Page {
  public function year () : string {
    return $this->date()->toDate(option('date.formats.year'));
  }

  public function isTranslated () : Field {
    $fr = $this->content('fr')->blocks()->value();
    $en = $this->content('en')->blocks()->value();
    return new Field($this, 'isTranslated', $fr !== $en);
  }
}
