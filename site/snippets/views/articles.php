<?php
  // TODO archives by year
  $pages = $page->children()->listed();
  $categories = $page->categories()->toStructure();

  $category = $categories->filter(fn ($cat) => $cat->title()->slug() == param('voir'))->first();
  if ($category) {
    $pages = $pages->filter(fn ($page) => in_array($category->title()->slug(), $page->categories()->split()));
  }
?>

<?php snippet('components/Header', [
  'title' => ($category ?? $page)->title(),
  'content' => ($category ?? $page)->description()->kirbytext(),
  'label' => $category ? snippet('html/link', $page, true) : null
]) ?>

<?php snippet('components/Article', [
  'title' => $page->title()
], slots: true) ?>
  <?php slot('sidebar') ?>
    <ul class='tags'>
      <li>
        <?= Html::a($page, t('filter.clear'), ['class' => r(!$category, 'is-active')])  ?>
      </li>

      <?php foreach ($categories as $category) : ?>
        <li>
          <?php snippet('html/category', ['slug' => $category->title()->slug()]) ?>
        </li>
      <?php endforeach ?>
    </ul>

    <ul class='archives'>
      // TODO archives by year
    </ul>
  <?php endslot() ?>

  <?php slot('content') ?>
    <?php snippet('components/Articles', ['pages' => $pages]) ?>
  <?php endslot() ?>
<?php endsnippet() ?>
