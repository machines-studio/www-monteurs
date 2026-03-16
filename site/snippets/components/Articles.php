<ul class='articles'>
  <?php foreach ($pages as $page) : ?>
    <li class='articles__entry'>
      <?php snippet('components/Label', $page) ?>

      <h2>
        <a href='<?= $page->url() ?>'><?= $page->title() ?></a>
      </h2>

      <?php snippet('html/image', ['image' => $page->cover()->toFile()]) ?>

      <div class='excerpt'>
        <?= $page->description()->or($page->blocks()->toBlocks())->excerpt(280) ?>
      </div>

      <a href='<?= $page->url() ?>' class='readmore'><?= t('readmore') ?></a>
    </li>
  <?php endforeach ?>
</ul>
