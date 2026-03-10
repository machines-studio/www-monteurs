<?php snippet('header') ?>
<?php snippet('menu') ?>

<main id="main" role="main">
  <div class="js-wrapper" data-namespace="<?= $page->template() ?>">

    <div class="featured">
      <div class="featured__wrapper">
        <section class="featured__hero">
          <ul class="featured__hero-items">
          <?php // NOTE: the featured field is between 1 and 2 articles ?>
          <?php foreach ($page->featured()->pages(',') as $item) : ?>
          <?php $cover = $item->cover()->isNotEmpty() ? $item->image($item->cover()) : null ?>
            <li class="featured__hero-item <?= $cover ? 'has-cover' : '' ?>">
              <?php snippet('label', ['article' => $item]) ?>
              <a class="featured__hero-item-link" href="<?= $item->url() ?>">
                <?php if ($cover) : ?>
                <figure class="featured__hero-item-cover" style="background-image: url(<?= $cover->url() ?>); background-position: <?= $cover->focusPercentageX() ?>% <?= $cover->focusPercentageY() ?>%;"></figure>
                <?php endif ?>
                <div class="featured__hero-item-title">
                  <?= kirbytext($item->title()) ?>
                </div>
              </a>
            </li>
          <?php endforeach ?>
          </ul>
        </section>

        <?php foreach ($banners as $items) : ?>
        <section class="featured__banner">
          <?php for ($i = 0; $i < 10; $i++) : ?>
          <ul class="featured__banner-items">
          <?php foreach ($items as $item) : ?>
            <li class="featured__banner-item">
              <a class="featured__banner-item-link" href="<?= $item->url() ?>">
                <?= $item->title()->html() ?>
              </a>
            </li>
          <?php endforeach ?>
          </ul>
          <?php endfor ?>
        </section>
        <?php endforeach ?>
      </div>

      <section class="featured__members">
        <header class="featured__members-header" id="actualite-des-adherents">
          <div class="featured__members-header-title">
            <?php snippet('link', ['obj' => $site->page('actualite-des-adherents')]) ?>
          </div>
        </header>
        <ul class="featured__members-items">
        <?php foreach ($memberNews as $item) : ?>
          <?php if ($image = $item->image($item->cover())) : ?>
          <li class="featured__members-item">
            <a class="featured__members-item-link" href="<?= $item->url() ?>" title="<?= $item->title() ?>">
              <?php
                $size = min(400, $image->width());
                snippet('image', [
                  'lazy' => true,
                  'image' => $image->focusCrop($size, $size, ['quality' => 70]),
                  'alt' => $item->title()
                ])
              ?>
            </a>
          </li>
          <?php endif ?>
        <?php endforeach ?>
        </ul>
      </section>
    </div>

  </div>
</main>

<?php snippet('footer') ?>
