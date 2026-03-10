<?php snippet('header', ['nofollow' => true]) ?>
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
      <aside class="main__sidebar">
        <?php snippet('sidebar', ['toc' => $page->text()->toc(1)]) ?>
      </aside>
      <div class="main__content">
        <?php snippet('article', ['article' => $page]) ?>
      </div>
    </section>

  </div>
</main>

<?php snippet('footer') ?>
