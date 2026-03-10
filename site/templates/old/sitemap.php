<?php snippet('header') ?>
<?php snippet('menu') ?>

<main id="main" role="main">
  <div class="js-wrapper" data-namespace="<?= $page->template() ?>">

    <header class="main__header">
      <div class="main__header-pusher"></div>
      <section class="main__header-content">
        <?php // NOTE: for all children of lists.*.yml blueprint ?>
        <?php if (str::contains($page->parent()->intendedTemplate(), 'list')) : ?>
        <?php snippet('label', ['article' => $page]) ?>
        <?php endif ?>

        <h1 class="main__header-title"><?= $page->title()->html() ?></h1>

        <?php if ($page->description()->isNotEmpty()) : ?>
        <div class="main__header-description article__content">
          <?= $page->description()->kirbytext() ?>
        </div>
        <?php endif ?>
      </section>
    </header>

    <section class="main__body">
      <aside class="main__sidebar"></aside>
      <div class="main__content">
        <div class="sitemap"><?= $sitemap ?></div>
      </div>
    </section>

  </div>
</main>

<?php snippet('footer') ?>
