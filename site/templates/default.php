<?php
  if (!isset($_SERVER['HTTP_X_BARBA'])) {
    snippet('html/header');
    snippet('components/Menu');
  }
?>

<main
  data-barba='container'
  data-uri='<?= ($page->parents()->first() ?? $page)?->slug() ?>'
  data-barba-namespace='<?= $view = $page->intendedTemplate()->name() ?>'
  data-title='<?= snippet('html/title', [], true) ?>'
>
  <?php snippet(["views/$view", 'views/default']) ?>
</main>

<?php
  if (!isset($_SERVER['HTTP_X_BARBA'])) {
    snippet('components/Photoswipe');
    snippet('html/footer');
  }
?>
