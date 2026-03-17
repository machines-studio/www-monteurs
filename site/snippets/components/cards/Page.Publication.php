<?php
  $cover = $page->cover()->toFile();
?>

<div class='card card--publication'>
  <a href='<?= $page->url() ?>'>
    <?php if ($cover) : ?>
      <?php snippet('html/image', ['image' => $cover]) ?>
    <?php else : ?>
      <div
        class='cover-placeholder'
        style='--card-color-accent: <?= $page->color()->toHex()->or('initial') ?>'
        aria-hidden
      >
        <span><?= $page->title()->kirbytext() ?></span>
        <div>
          <?php snippet('svg/logo-compact') ?>
          <?= $page->title()->kirbytext() ?>
        </div>
      </div>
    <?php endif ?>
  </a>

  <?php snippet('components/Label', $page) ?>

  <h2>
    <a href='<?= $page->url() ?>'><?= $page->title() ?></a>
  </h2>
</div>
