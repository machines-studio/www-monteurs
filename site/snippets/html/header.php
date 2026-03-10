<!DOCTYPE html>
<html lang='<?= $kirby->language()->code() ?>'>

<head>
  <meta charset='UTF-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>

  <?php if (isset($nofollow) && $nofollow) : ?>
    <meta name="robots" content="noindex, nofollow">
  <?php endif ?>

  <title><?php snippet('html/title') ?></title>
  <?php snippet('html/seo') ?>

  <link rel='alternate' type='application/rss+xml' href='<?= url('feed') ?>' title='<?= html($pages->find('feed')?->title() ?? 'Feed') ?>' />

  <?= vite()->css('index.scss') ?>
  <?= vite()->js('index.js', ['defer' => true]) ?>

  <script>
    document.getElementsByTagName('html')[0].className = 'js'
    document.getElementsByTagName('html')[0].dataset.hash = encodeURIComponent(window.location.hash.substr(1))
  </script>
</head>

<body data-barba='wrapper'>
