<?php
  $query = esc(get('q') ?? '');
  $pages = $site->search($query, [
    'minlength' => 3,
    'fields' => ['title', 'blocks', 'description'],
    'words' => true,
    'score' => [
      'title' => 128,
      'blocks' => 64,
      'description' => 64
    ]
  ]);
?>

<?php snippet('components/Header', [
  'label' => $query
    ? tc('search.count', $pages->count()) . ' ' . tt('search.query', ['query' => $query])
    : $page->title(),
], slots: true) ?>
  <?php slot('content') ?>
    <form>
      <input
        type='search'
        autofocus
        placeholder='<?= t('search.placeholder') ?>'
        name='q'
        value='<?= $query ?>'
      />
      <button type='submit'>
        <?php snippet('svg/search') ?>
      </button>
    </form>
  <?php endslot() ?>
<?php endsnippet() ?>

<?php snippet('components/Article', slots: true) ?>
  <?php slot('content') ?>
    <?php snippet('components/Articles', ['pages' => $pages]) ?>
  <?php endslot() ?>
<?php endsnippet() ?>
