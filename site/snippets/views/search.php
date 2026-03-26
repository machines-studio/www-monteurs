<?php
  $query = esc(get('q') ?? '');
  $pages = $site->search($query, [
    'minlength' => 2,
    'fields' => ['title', 'blocks', 'description'],
    'words' => strlen($query ?? '') <= 3,
    'score' => [
      'title' => 128,
      'blocks' => 64,
      'description' => 64
    ]
  ]);
?>

<?php snippet('views/pages', [
  'pages' => $pages,
  'archives' => false,
  'title' => false,
  'label' => $query
    ? tc('search.count', $pages->count()) . ' ' . tt('search.query', ['query' => $query])
    : $page->title(),
  'cardTemplate' => 'components/cards/Page',
], slots: true) ?>
  <?php slot('header') ?>
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
