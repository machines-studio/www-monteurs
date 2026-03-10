<?php snippet('header') ?>
<?php snippet('menu') ?>

<main id="main" role="main">
  <div class="js-wrapper" data-namespace="<?= $page->template() ?>">

    <header class="main__header">
      <div class="main__header-pusher"></div>
      <section class="main__header-content">
        <h1 class="main__header-title"><?= $page->title()->html() ?></h1>
      </section>
    </header>

    <section class="main__body">

      <div class="main__content">
        <div class="publications">
          <ul class="publications__items">
          <?php foreach ($page->children()->visible() as $publication) : ?>
            <li class="publications__item">
              <article class="publication">
                <a class="publication__link" href="<?= $publication->url() ?>">
                  <?php if ($image = $publication->cover()->isNotEmpty() ? $publication->image($publication->cover()) : null) : ?>
                  <?php snippet('article-figure', [
                    'lazy' => true,
                    'ratio' => 148/210, // A3 ratio
                    'width' => 500,
                    'image' => $image,
                    'class' => 'publication__cover'
                  ]) ?>
                  <?php else: ?>
                    <div class="publication__cover publication__cover--placeholder" data-color="<?= $publication->color() ?>">
                      <div class="publication__cover--placeholder-background">
                        <span><?= $publication->title()->kirbytext() ?></span>
                      </div>
                      <div class="publication__cover--placeholder-title">
                        <div class="publication__cover--placeholder-title-logo"><?php snippet('svg/logo--compact') ?></div>
                        <?= $publication->title()->kirbytext() ?>
                      </div>
                    </div>
                  <?php endif ?>
                  <?php snippet('label', [
                    'article' => $publication,
                    'nolink' => true
                  ]) ?>
                  <h1 class="publication__title">
                    <?= $publication->title()->html() ?>
                  </h1>
                </a>
              </article>
            </li>
          <?php endforeach ?>
          </ul>
        </div>
      </div>
    </section>

  </div>
</main>

<?php snippet('footer') ?>
