<ul class='articles'>
  <?php foreach ($pages as $page) : ?>
    <li>
      <?php snippet('components/Label', $page) ?>

      <h2>
        <a href='<?= $page->url() ?>'><?= $page->title() ?></a>
      </h2>

      <div class='excerpt'>
        <?= $page->description()->or($page->blocks())->excerpt(140) ?>
      </div>

      <a href='<?= $page->url() ?>' class='readmore'><?= t('readmore') ?></a>
    </li>
  <?php endforeach ?>
</ul>
