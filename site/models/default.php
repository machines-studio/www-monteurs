<?php

use Kirby\Cms\Page;
use Kirby\Content\Field;

class DefaultPage extends Page {
  public function year () : string {
    return $this->date()->toDate(option('date.formats.year')) ?? '';
  }

  public function isTranslated () : Field {
    $fr = $this->content('fr')->blocks()->toBlocks()->toHtml();
    $en = $this->content('en')->blocks()->toBlocks()->toHtml();
    return new Field($this, 'isTranslated', $fr !== $en);
  }
}
