<div class='interview prose'>
  <div class='question'>
    <h6><?= $block->expedient() ?></h6>
    <?= $block->question()->kirbytext()->before('coucou') ?>
  </div>
  <div class='answer prose'>
    <h6><?= $block->recipient() ?></h6>
    <?= $block->answer()->kirbytext() ?>
  </div>
</div>
