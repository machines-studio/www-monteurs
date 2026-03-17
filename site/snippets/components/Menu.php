<input type='checkbox' id='toggle-menu'>

<nav class='menu'>
  <a
    id='home'
    href='<?= $site->url() ?>'
    title='<?= t('menu.go-home') ?>'
    class='<?= r($page->isHomepage(), 'is-active') ?>'
  >
    <?php snippet('svg/logo') ?>
  </a>

  <label for='toggle-menu'>
    <?php snippet('svg/menu') ?>
    <?php snippet('svg/close') ?>
  </label>

  <menu class='menu__items'>
    <?php foreach ($site->children()->listed() as $child) : ?>
      <?php if ($child->isHomepage()) continue ?>

      <li class='menu__item'>
        <?php snippet('html/link', $child) ?>
      </li>
    <?php endforeach ?>

    <li class='menu__item'>
      <a href='<?= page('search')->url() ?>'>
        <?php snippet('svg/search') ?>
      </a>
    </li>
  </menu>
</nav>
