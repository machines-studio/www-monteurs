<?php if ($audio = $block->file()->toFile()) : ?>
  <figure class='audio'>
    <audio
      controls
      loading='lazy'
      src='<?= $audio->url() ?>'
    ></audio>

    <?php if ($block->caption()->isNotEmpty()) : ?>
      <figcaption><?= $block->caption() ?></figcaption>
    <?php endif ?>
  </figure>
<?php endif ?>
