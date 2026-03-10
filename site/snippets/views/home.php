<?php
  $pins = $page->pinned()->toStructure();
  $members = $site->page('actualite-des-adherents')->children()->listed()->flip()->limit(6);
?>

<ul class='pinned__pages'>
  <?php foreach ($pins as $pin) : ?>
    <?php
      $page = $pin->page()->toPage();
      if (!$page) continue;
      $size = $pin->large()->bool() ? 'large' : 'normal';
      $cover = $pin->cover()->bool() ? $page->cover()->toFile() : null;
      $color = $pin->color()->toHex();
    ?>

    <li <?= attr([
      'class' => ['pinned__page', r($cover, 'has-cover')],
      'data-size' => $size,
      'style' => "--color-accent: {$color}"
    ]) ?>>
      <div>
        <?php snippet('components/Label', $page) ?>
        <h2>
          <a href='<?= $page->url() ?>'>
            <?= $page->title() ?>
          </a>
        </h2>
      </div>

      <?php snippet('html/image', ['image' => $cover]) ?>
    </li>
  <?php endforeach ?>
</ul>

<section class='members'>
  <header>
    <?php snippet('html/link', page('actualite-des-adherents')) ?>
    <?php snippet('html/link', page('annoncer-une-actualite')) ?>
  </header>
  <ul class='members__items'>
    <?php foreach ($members as $member) : ?>
      <li class='members__item'>
        <a href='<?= $member->url() ?>' title='<?= $member->title()->html() ?>'>
          <?php snippet('html/image', [
            'image' => $member->cover()->toFile()
          ]) ?>
        </a>
      </li>
    <?php endforeach ?>
  </ul>
</section>
