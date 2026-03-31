<?php

include_once 'helpers.php';
date_default_timezone_set('Europe/Paris');

return [
  'debug' => false,
  'cache' => true,
  'smartypants' => true,
  'languages' => true,

  'colors' => [
    '#4200FA',
    '#38B4FF',
    '#00BE40',
    '#FFB400',
    '#F83053',
  ],

  'date' => [
    'handler' => 'intl',
    'formats' => [
      'year' => intl('yyyy'),
      'file' => intl('yyyyMMdd'),
      'iso' => intl('yyyy-MM-dd'),
      'full' => intl('dd MMMM yyyy')
    ]
  ],

  'thumbs' => [
    'driver' => 'im',

    'srcsets' => [
      'default' => [
        '200w' => ['width' => 200, 'format' => 'webp'],
        '600w' => ['width' => 600, 'format' => 'webp'],
        '800w' => ['width' => 800, 'format' => 'webp'],
        '1200w' => ['width' => 1200, 'format' => 'webp'],
        '1600w' => ['width' => 1600, 'format' => 'webp'],
        '1920w' => ['width' => 1920, 'format' => 'webp']
      ]
    ],

    'sizes' => [
      'default' => '100vw',
      'small' => '1vw',
      'half' => implode(',', [
        '(max-width: 1024px) 100vw',
        '50vw'
      ]),
      'card' => implode(',', [
        '(max-width: 800px) 100vw',
        '(max-width: 1024px) 25vw',
        '20vw'
      ])
    ]
  ],

  'panel' => [
    'menu' => fn ($kirby) => array_merge([
      'site' => [
        'label' => 'Site',
        'icon' => 'globe',
        'current' => function () : bool {
          $links = ['site'];
          $path  = Kirby\Cms\App::instance()->path();
          return Str::contains($path, 'site');
        }
      ]
    ],
    // Listed
    (function () use ($kirby) {
      $items = ['-'];
      foreach ($kirby->site()->children()->listed() as $group) {
        $id = $group->slug();
        $items[$id] = menu($kirby, $id);
      }
      return $items;
    })(),
    [
      '-',
      'users',
      '-',
      'retour',
      'backups',
      'languages',
      'system'
    ])
  ],

  'sitemap' => [
    'ignore' => [
      'home',
      'feed',
      'bac-a-sable',
      'annoncer-une-actualite',
      'sitemap',
      'erreur',
      'error',
      'backups'
    ]
  ],

  'routes' => [
    [ // Redirect non translated content to fr
      'pattern' => ['en', 'en/(:all)'],
      'action' => function ($slug = '') {
        $page = page($slug);
        if ($page->isTranslated()->bool()) return $this->next();

        return $page ? go($page->url('fr')) : null;
      }
    ],

    [ // Sitemap for robots
      'pattern' => ['sitemap.xml', 'sitemap_index.xml'],
      'action'  => function () {
        $content = snippet('html/sitemap', [
          'pages' => site()->pages()->index(),
          'ignore' => kirby()->option('sitemap.ignore', ['error'])
        ], true);
        return new Kirby\Cms\Response($content, 'application/xml');
      }
    ],

    [ // RSS
      'pattern' => ['feed', 'rss', 'feed.rss'],
      'action'  => function () {
        $content = snippet('html/feed', [], true);
        return new Kirby\Cms\Response($content, 'application/xml');
      }
    ],

    [ // Sitemap for humans
      'pattern' => 'sitemap',
      'action' => function () {
        return new Page(['slug' => 'sitemap', 'template' => 'sitemap']);
      }
    ],

    [ // Quick panel access from any page by appending /panel to the url
      'pattern' => '(:all)/panel',
      'action' => function ($uid) {
        if ($page = page($uid)) return go($page->panel()->url());
        return go('/panel');
      }
    ],

    [ // Quick panel access from any page by appending /panel to the url
      'pattern' => '(fr|en)/(:all)/panel',
      'action' => function ($lang, $uid) {
        if ($page = page($uid)) return go($page->panel()->url() . "?language=$lang");
        return go('/panel');
      }
    ]
  ],

  'ready' => fn () => [
    'panel' => [
      'css' => vite()->panelCss('panel.js'),
      'js' => vite()->panelJs('panel.js')
    ]
  ]
];
