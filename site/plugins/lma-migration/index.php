<?php

namespace LMA;
use \Kirby;
use \Kirby\Cms\Pages;
use \Kirby\Http\Header;

// Used to keep track of migrated files
const VERSION = [
  'blocks' => '1.0.0',
  'attachments' => '1.0.0',
  'template' => '1.0.0'
];

// Map templates migration
const TEMPLATES = [
  'article' => 'page',
  'form.add-member-new' => 'submit',
  'list.articles' => 'pages',
  'list.member-news' => 'members',
  'list.publications' => 'pages',
  'member-new' => 'member',
  'publication' => 'page.publication'
];

Kirby::plugin('lma/migration', [
  'version' => VERSION,

  'options' => [
    'enabled' => false // Enable only in the desired config.env.php
  ],

  'routes' => [
    [
      'pattern' => ['migrate', 'migrate/(:all)'],
      'action' => function () {
        if (option('lma.migration.enabled')) return $this->next();
        Header::forbidden();
        die('Forbidden');
      }
    ],

    [ // Return a list of target pages
      'pattern' => ['(:all)/migrate/log', 'migrate/log'],
      'action' => fn ($slug = null) => update(
        [page($slug), ...($slug ? page($slug) : site())->index()],
        null,
        fn ($page) => $page
      )
    ],

    [ // Add the migration flags to pages content
      'pattern' => ['(:all)/migrate/flag', 'migrate/flag'],
      'action' => fn ($slug = null) => update(
        [page($slug), ...($slug ? page($slug) : site())->index()],
        null,
        fn ($page, string $lang) => $page->update(['migration' => VERSION])
      )
    ],

    [ // Remove the migration flags to pages conten
      'pattern' => ['(:all)/migrate/unflag', 'migrate/unflag'],
      'action' => fn ($slug = null) => update(
        [page($slug), ...($slug ? page($slug) : site())->index()],
        null,
        fn ($page, string $lang) => $page->update(['migration' => null])
      )
    ],

    [ // Migrate obsolete templates
      'pattern' => ['(:all)/migrate/template', 'migrate/template'],
      'action' => fn ($slug = null) => update(
        [page($slug), ...($slug ? page($slug) : site())->index()],
        'template',
        function ($page) {
          $old = $page->intendedTemplate()->name();
          if (!in_array($old, array_keys(TEMPLATES))) return;
          $new = TEMPLATES[$old];

          foreach (kirby()->languages() as $language) {
            $lang = $language->code();
            $oldFile = $page->root() . '/' . $old . '.' . $lang . '.txt';
            $newFile = $page->root() . '/' . $new . '.' . $lang . '.txt';
            if (file_exists($oldFile)) rename($oldFile, $newFile);
          }

          return page($page->id());
        }
      )
    ],

    [ // Migrate text: prop to a markdown block
      'pattern' => ['(:all)/migrate/blocks', 'migrate/blocks'],
      'action' => fn ($slug = null) => update(
        [page($slug), ...($slug ? page($slug) : site())->index()],
        'blocks',
        function ($page, string $lang) {
          if (!in_array('blocks', array_keys($page->blueprint()->fields()))) return;
          if ($page->text()->isEmpty()) return;

          return $page->update([
            'text' => null,
            'blocks' => array_merge(
              $page->blocks()->toBlocks()->toArray(),
              [
                [
                  'type' => 'markdown',
                  'content' => ['text' => $page->text()->value()]
                ]
              ]
            )
          ], $lang);
        }
      )
    ],

    [ // Migrate attachments: prop structure
      'pattern' => ['(:all)/migrate/attachments', 'migrate/attachments'],
      'action' => fn ($slug = null) => update(
        [page($slug), ...($slug ? page($slug) : site())->index()],
        'attachments',
        function ($page, string $lang) {
          if (!in_array('attachments', array_keys($page->blueprint()->fields()))) return;
          if ($page->attachments()->isEmpty()) return;

          $attachments = [];
          foreach ($page->attachments()->toStructure() as $attachment) {
            $link = $attachment->url()->value() ?? $attachment->link()->value();
            if ($attachment->file()->isNotEmpty()) $link = $page->file($attachment->file())?->uuid();
            if ($attachment->page()->isNotEmpty()) $link = $page->page($attachment->page())?->uuid();
            if (!$link) continue;

            $attachments[] = [
              'link' => $link,
              'text' => $attachment->text()->value() ?? ''
            ];
          }

          return $page->update(['attachments' => $attachments], $lang);
        }
      )
    ]
  ]
]);

function update (iterable $pages, $namespace, $callback) : mixed {
  $kirby = kirby();
  $slugs = [];
  foreach ($kirby->languages() as $language) {
    $lang = $language->code();
    $kirby->setCurrentLanguage($lang);

    foreach ($pages as $page) {
      // Do not reuse mutated cached $pages[$page]
      $page = page($page->id());

      // Avoid double migration on a same semver
      if ($namespace) {
        $migration = $page->migration()->yaml();
        if (version_compare($migration[$namespace] ?? '0.0.0', VERSION[$namespace], '>=')) continue;
      }

      // Update page with callback
      $page = $callback($page, $lang) ?? $page;

      if ($namespace) {
        // Keep track of migration
        $page = $page->update([
          'migration' => [
            ...$migration,
            $namespace => VERSION[$namespace]
          ],
        ], $lang);
      }

      // Log update
      $slugs[] = "$lang/" . $page->slug();
    }
  }
  return $kirby->response()->json($slugs);
}
