<?php

use Kirby\Cms\Page;
use Kirby\Content\Field;

class DefaultPage extends Page {
  public function year () : string {
    return $this->date()->toDate(option('date.formats.year')) ?? '';
  }

  public function isTranslated () : Field {
    $fr = Str::unhtml($this->content('fr')->blocks()->toBlocks()->toHtml());
    $en = Str::unhtml($this->content('en')->blocks()->toBlocks()->toHtml());
    return new Field($this, 'isTranslated', trim($en) && $fr != $en);
  }
}
