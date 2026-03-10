<?php snippet('header') ?>
<?php snippet('menu') ?>

<main id="main" role="main">
  <div class="js-wrapper" data-namespace="<?= $page->template() ?>">

    <header class="main__header">
      <div class="main__header-pusher"></div>
      <section class="main__header-content">
        <?php snippet('label', ['article' => $page, 'nolink' => true]) ?>

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
            r($page->buy()->isNotEmpty(), '<a href="'. $page->buy() .'" target="_blank">commander '. ($page->price()->isNotEmpty() ? '(' . number_format($page->price()->value(), 2, ',', ' ') . '&thinsp;&euro;)' : '') .'</a>')
          ],
          'attachments' => $page->attachments()->toStructure()
        ]) ?>
      </aside>
      <div class="main__content">
        <?php snippet('article', ['article' => $page]) ?>
      </div>
    </section>

  </div>
</main>

<?php snippet('footer') ?>
