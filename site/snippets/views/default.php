<?php
  $otherLang = 'fr';
  foreach (kirby()->languages() as $lang) {
    if ($lang->code() !== kirby()->language()->code()) {
      $otherLang = $lang;
      break;
    }
  }
?>

<?php snippet('components/Header', [
  'title' => $page->title(),
  'label' => snippet('components/Label', $page, true),
  'content' => $page->description()->kirbytext()
]) ?>

<?php snippet('components/Article', [
  'label' => r($page->isTranslated()->bool(), snippet('html/link', [
    'url' => $page->url($otherLang->code()),
    'text' => t('translation'),
    'attributes' => ['target' => false]
  ], true)),
  'sidebar' => $slots->sidebar()
], slots: true) ?>
  <?php slot('sidebar') ?>
    <ul class='toc'>
      <?= $page->blocks()->toToc() ?>
    </ul>

    <ul class='attachments'>
      <?php foreach ($page->attachments()->toStructure() as $attachment) : ?>
        <li>
          <?php snippet('html/link', [
            'link' => $attachment->link(),
            'text' => $attachment->text()
          ]) ?>
        </li>
      <?php endforeach ?>
    </ul>
  <?php endslot() ?>

  <?php slot('content') ?>
    <?= snippet('html/image', [
      'image' => $page->cover()->toFile(),
      'photoswipe' => true
    ]) ?>
    <?= $page->blocks()->toBlocks() ?>
  <?php endslot() ?>
<?php endsnippet() ?>
