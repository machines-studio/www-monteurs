<?php snippet('components/Header', [
  'title' => $page->title(),
  'label' => null, // WIP
  'content' => $page->description()->kirbytext()
]) ?>

<?php snippet('components/Article', [
  'title' => $page->title()
], slots: true) ?>
  <?php slot('sidebar') ?>
    <ul class='toc'>
      <?= $page->blocks()->toToc() ?>
    </ul>

    <ul class='attachments'>
      <?php foreach ($page->attachments()->toStructure() as $attachment) : ?>
        <li>
          <?php snippet('html/link', $attachment->link()) ?>
        </li>
      <?php endforeach ?>
    </ul>
  <?php endslot() ?>

  <?php slot('content') ?>
    <?= $page->blocks()->toBlocks() ?>
  <?php endslot() ?>
<?php endsnippet() ?>
