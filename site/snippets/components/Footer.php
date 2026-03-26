<?php
  $email = $site->email()->isNotEmpty() ? 'mailto:' . Str::encode($site->email()) : null;

  $links = [
    page('contact'),

    [
      'url' => $site->newsletter(),
      'text' => t('footer.newsletter')
    ],

    [
      'url' => r($site->facebook()->isNotEmpty(), 'https://facebook.com/' . $site->facebook()),
      'text' => 'facebook'
    ],

    [
      'url' => r($site->instagram()->isNotEmpty(), 'https://instagram.com/' . $site->instagram()),
      'text' => 'instagram'
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
      <?php if (trim($l = snippet('html/link', $link, true))) : ?>
        <li class='footer__link'>
          <?= $l ?>
        </li>
      <?php endif ?>
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
