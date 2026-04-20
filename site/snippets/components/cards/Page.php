<div class='card card--page' data-template='<?= $page->intendedTemplate()->name() ?>'>
  <?php snippet('components/Label', ['item' => $page, 'showDate' => $showDate ?? null]) ?>

  <h2>
    <a href='<?= $page->url() ?>'>
      <?php if (in_array('comptes-rendus', $page->categories()->split())) echo Html::span('Compte rendu', ['class' => 'comptes-rendus']) ?>
      <?= $page->title() ?>
    </a>
  </h2>

  <a href='<?= $page->url() ?>'>
    <?php snippet('html/image', ['image' => $page->cover()->toFile()]) ?>
  </a>

  <div class='excerpt'>
    <?= $page->description()->or($page->blocks()->toBlocks())->excerpt(280) ?>
  </div>

  <a href='<?= $page->url() ?>' class='readmore'><?= t('readmore') ?></a>
</div>
