<?php snippet('header') ?>
<?php snippet('menu') ?>

<main id="main" role="main">
  <div class="js-wrapper" data-namespace="<?= $page->template() ?>">

    <header class="main__header">
      <div class="main__header-pusher"></div>
      <section class="main__header-content">
        <?php snippet('label', ['article' => $page]) ?>

        <h1 class="main__header-title"><?= $page->title()->html() ?></h1>

        <?php if ($page->description()->isNotEmpty()) : ?>
        <div class="main__header-description article__content">
          <?= $page->description()->kirbytext() ?>
        </div>
        <?php endif ?>
      </section>
    </header>

    <section class="main__body">
      <aside class="main__sidebar">
        <?php snippet('sidebar', [
          'actions' => [
            snippet('link', ['obj' => $site->page('annoncer-une-actualite')], true)
          ],
          'toc' => $page->text()->toc(1),
          'attachments' => [
            ['title' => 'Partager sur Facebook', 'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . escape::url($page->url())],
            ['title' => 'Partager sur Twitter', 'url' => 'https://twitter.com/home?status=' . escape::url($page->url())]
          ]
        ]) ?>
      </aside>
      <div class="main__content">
        <?php snippet('article', ['article' => $page]) ?>
      </div>
    </section>

  </div>
</main>

<?php snippet('footer') ?>
