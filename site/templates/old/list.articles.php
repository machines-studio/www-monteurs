<?php snippet('header') ?>
<?php snippet('menu') ?>

<main id="main" role="main">
  <div class="js-wrapper" data-namespace="<?= $page->template() ?>">

    <header class="main__header">
      <div class="main__header-pusher"></div>
      <section class="main__header-content">
      <?php if ($current_category) : ?>
        <div class="label">
          <a class="label__category" href="<?= url('./') ?>">
            <?= $page->title()->html() ?>
          </a>
        </div>
        <h1 class="main__header-title"><?= $current_category->title() ?></h1>
        <?php if ($current_category->description()->isNotEmpty()) : ?>
        <div class="main__header-description article__content">
          <?= $current_category->description()->kirbytext() ?>
        </div>
        <?php endif ?>
      <?php else : ?>
        <h1 class="main__header-title"><?= $page->title()->html() ?></h1>
      <?php endif ?>
      </section>
    </header>

    <section class="main__body">
      <aside class="main__sidebar">
        <?php snippet('sidebar', [
          'filters' => $categories,
          'years' => $years,
          'current_year' => $current_year
        ]) ?>
      </aside>
      <div class="main__content">
      <?php foreach ($articles as $article) : ?>
      <?php snippet('article-excerpt', [
        'article' => $article,
        'length' => 300
      ]) ?>
      <?php endforeach ?>
      </div>
    </section>

  </div>
</main>

<?php snippet('footer') ?>
