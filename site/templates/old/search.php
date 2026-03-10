<?php snippet('header') ?>
<?php snippet('menu') ?>

<main id="main" role="main">
  <div class="js-wrapper" data-namespace="<?= $page->template() ?>">

    <header class="main__header">
      <div class="main__header-pusher"></div>
      <section class="main__header-content">
        <?php if ($query) : ?>
        <div class="label">
          <?=
            ($results->count() > 0
              ? $results->count() . ' résultat' . ($results->count() > 1 ? 's' : '')
              : 'aucun résultat trouvé') . ' pour la recherche : '
          ?>
        </div>
        <?php endif ?>
        <form class="searchform">
          <input class="searchform__input" autofocus type="search" placeholder="rechercher…" name="q" value="<?= esc($query) ?>">
          <button class="searchform__button" type="submit"><?php snippet('svg/magnifying-glass') ?></button>
        </form>
      </section>
    </header>

    <section class="main__body">
      <aside class="main__sidebar"></aside>
      <div class="main__content">
        <?php foreach ($results as $result) : ?>
        <?php snippet('article-excerpt', [
          'article' => $result,
          'length' => 300
        ]) ?>
        <?php endforeach ?>
      </div>
    </section>

  </div>
</main>

<?php snippet('footer') ?>
