<?php snippet('header', ['nofollow' => true]) ?>
<?php snippet('menu') ?>

<main id="main" role="main">
  <div class="js-wrapper" data-namespace="<?= $page->template() ?>">

    <header class="main__header">
      <div class="main__header-pusher"></div>
      <section class="main__header-content">
        <?php // NOTE: for all children of lists.*.yml blueprint ?>
        <?php if (str::contains($page->parent()->intendedTemplate(), 'list')) : ?>
        <?php snippet('label', ['article' => $page]) ?>
        <?php endif ?>

        <h1 class="main__header-title"><?= $page->title()->html() ?></h1>

        <?php if ($page->description()->isNotEmpty()) : ?>
        <div class="main__header-description article__content">
          <?= $page->description()->kirbytext() ?>
        </div>
        <?php endif ?>
      </section>
    </header>

    <section class="main__body">
      <aside class="main__sidebar"></aside>
      <div class="main__content">
        <article class="article">
          <form class="form" method="post" action="<?= $page->url() ?>#formulaire" enctype="multipart/form-data">
            <?php if (isset($success)) : ?>
            <div class="form__result-success">
              <?= $success->kirbytext() ?>
            </div>
            <?php elseif (isset($failed)) : ?>
            <div class="form__result-fail">
              <?= $failed->kirbytext() ?>
              <?php if (isset($err)) : ?>
              <pre><?= $err ?></pre>
              <?php endif ?>
            </div>
            <?php endif ?>

            <div class="form__anchor" id="formulaire"></div>

            <div class="form__honeypot">
              <label for="website">Website <abbr title="required">*</abbr></label>
              <input type="website" id="website" name="website" value="<?= isset($data['website']) ? $data['website'] : '' ?>">
              <input type="hidden" name="csrf" value="<?= csrf() ?>">
            </div>

            <?php foreach ($fields as $field_id => $field) : ?>
            <div class="form__field <?php e(isset($alert[$field_id]), 'has-error') ?>">
              <label class="form__field-label" for="<?= $field_id ?>">
                <?= $field['value'] ?>

                <?php if ($field['required']) : ?>
                <abbr class="form__field-label-required" title="Champ obligatoire">*</abbr>
                <?php endif ?>
              </label>
              <?php if ($field['type'] === 'textarea') : ?>
                <textarea class="form__field-textarea" id="<?= $field_id ?>" name="<?= $field_id ?>" rows="10"><?= isset($data[$field_id]) ? $data[$field_id] : '' ?></textarea>
              <?php else : ?>
                <input
                  class="form__field-input"
                  type="<?= $field['type'] ?>"
                  id="<?= $field_id ?>"
                  name="<?= $field_id ?>"
                  <?= $field_id == 'image' ? 'accept="image/*"' : '' ?>
                  <?= ($field_id == 'token' && isset($token) && $token) ? 'readonly' : '' ?>
                  value="<?= isset($data[$field_id]) ? $data[$field_id] : '' ?>">
              <?php endif ?>

              <?php if (isset($alert[$field_id])) : ?>
              <span class="form__field-error"><?= kirbytext($messages[$field_id]) ?></span>
              <?php endif ?>
            </div>
            <?php endforeach ?>

            <div class="form__field">
              <input class="form__field-submit" type="submit" name="submit" value="Soumettre">
            </div>
          </form>
        </div>
      </article>
    </section>

  </div>
</main>

<?php snippet('footer') ?>
