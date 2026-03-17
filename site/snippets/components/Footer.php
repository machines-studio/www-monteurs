<?php
  $email = $site->email()->isNotEmpty() ? 'mailto:' . Str::encode($site->email()) : null;

  $links = [
    page('contact'),

    [
      'url' => $site->newsletter(),
      'text' => t('footer.newsletter')
    ],

    page('sitemap'),

    [
      'url' => '/feed',
      'text' => t('footer.feed'),
    ],

    page('credits')
  ];

  $partners = $site->partners()->toStructure();
?>

<footer class='footer'>
  <ul class='footer__links'>
    <?php foreach ($links as $link) : ?>
      <li class='footer__link'>
        <?php snippet('html/link', $link) ?>
      </li>
    <?php endforeach ?>
  </ul>

  <ul class='footer__partners'>
    <?php foreach ($partners as $partner) : ?>
      <li class='footer__partner'>
        <a href='<?= $partner->url() ?>' target='_blank' title='<?= $partner->text()->html() ?>'>
          <?php snippet('html/image', [
            'image' => $partner->image()->toFile(),
            'lazyload' => false
          ]) ?>
        </a>
      </li>
    <?php endforeach ?>
  </ul>
</footer>
