<?php
  $pages ??= $page->children()->listed();
  $archives ??= false;

  $categories = $page->categories()?->toStructure();
  $category = $categories->filter(fn ($cat) => $cat->title()->slug() == param('voir'))->first();
  if ($category) {
    $pages = $pages->filter(fn ($page) => in_array($category->title()->slug(), $page->categories()->split()));
  }

  if ($archives) {
    $archive = param('archive') ?? date('Y');
    $years = $pages->pluck('year', ',', true);
    $pages = $pages->filter(fn ($page) => $page->year() == $archive);
  }

  $title ??= ($category ?? $page)->title();
  $label ??= $category ? snippet('html/link', $page, true) : null;
  $header ??= $slots->header() ?? ($category ?? $page)->description()->kirbytext();

  $cardTemplate ??= null;
?>

<?php snippet('components/Header', [
  'title' => $title,
  'content' => $header,
  'label' => $label
]) ?>

<?php snippet('components/Article', [
  'title' => $page->title()
], slots: true) ?>
  <?php slot('sidebar') ?>
    <?= $slots->sidebar() ?>

    <ul class='tags'>
      <?php if (count($categories)) : ?>
        <li>
          <?= Html::a($page, t('filter.clear'), ['class' => r(!$category, 'is-active')])  ?>
        </li>

        <?php foreach ($categories as $category) : ?>
          <li>
            <?php snippet('html/category', ['slug' => $category->title()->slug()]) ?>
          </li>
        <?php endforeach ?>
      <?php endif ?>

      <?php if ($archives) : ?>
        <li class='archives'>
          <details <?= r(param('archive'), 'open') ?>>
            <summary>archives</summary>
            <ul>
              <?php foreach ($years as $year) : ?>
                <li>
                  <?php snippet('html/link', [
                    'url' => url($page, [
                      'params' => [
                        ...params(),
                        'archive' => $year
                      ]
                    ]),
                    'active' => $year == param('archive', date('Y')),
                    'text' => $year
                  ]) ?>
                </li>
              <?php endforeach ?>
            </ul>
          </details>
        </li>
      <?php endif ?>
    </ul>
  <?php endslot() ?>

  <?php slot('content') ?>
    <?php foreach ($pages as $page) {
      snippet($cardTemplate ?? ["components/cards/" . ucfirst($page->intendedTemplate()->name()), 'components/cards/Page'], [
        'page' => $page,
        'showDate' => $showDate ?? null
      ]);
    } ?>
  <?php endslot() ?>
<?php endsnippet() ?>
