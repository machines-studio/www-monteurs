<div class='card card--page' data-template='<?= $page->intendedTemplate()->name() ?>'>
  <?php snippet('components/Label', $page) ?>

  <h2>
    <a href='<?= $page->url() ?>'><?= $page->title() ?></a>
  </h2>

  <a href='<?= $page->url() ?>'>
    <?php snippet('html/image', ['image' => $page->cover()->toFile()]) ?>
  </a>

  <div class='excerpt'>
    <?= $page->description()->or($page->blocks()->toBlocks())->excerpt(280) ?>
  </div>

  <a href='<?= $page->url() ?>' class='readmore'><?= t('readmore') ?></a>
</div>
