<?php

use Kirby\Cms\Page;
use Kirby\Content\Field;

class DefaultPage extends Page {
  public function year () : string {
    return $this->date()->toDate(option('date.formats.year')) ?? '';
  }

  public function isTranslated () : Field {
    $fr = $this->content('fr')->blocks()->toBlocks()->toString();
    $en = $this->content('en')->blocks()->toBlocks()->toString();
    return new Field($this, 'isTranslated', $fr !== $en);
  }
}
