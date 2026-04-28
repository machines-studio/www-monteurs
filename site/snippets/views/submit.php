<?php snippet('components/Header', [
  'title' => $page->title(),
  'content' => $page->description()->kirbytext()
]) ?>

<?php
  $image = $kirby->request()->files()->get('cover');
  $fields = [
    'email' => [
      'label' => 'e-mail',
      'type' => 'email',
      'value' => get('email'),
      'rule' => ['required' => true, 'email' => true],
      'error' => 'Merci d’entrer un e-mail valide'
    ],

    'token' => [
      'label' => 'clé de sécurité',
      'type' => 'text',
      'value' => get('token'),
      'rule' => ['required' => true, 'same' => $page->token()->value()],
      'help' => 'La clé de sécurité vous a été communiqué par e-mail au moment de votre adhésion ou ré-adhésion',
      'error' => $page->unauthorized()->value()
    ],

    'title' => [
      'label' => 'titre',
      'type' => 'text',
      'value' => get('title'),
      'rule' => ['required' => true],
      'error' => 'Merci d’entrer un titre'
    ],

    'diffusion' => [
      'label' => 'diffusion',
      'type' => 'text',
      'value' => get('diffusion'),
      'rule' => ['required' => true],
      'placeholder' => 'En salle, festival, chaîne de télévision, plateforme…',
      'error' => 'Merci d’indiquer les modalités de diffusion'
    ],

    'date' => [
      'type' => 'date',
      'help' => 'Date de la sortie ou de la diffusion',
      'value' => get('date'),
      'rule' => ['required' => true],
      'error' => 'Merci d’entrer une date valide'
    ],

    'team' => [
      'label' => 'Équipe',
      'tag' => 'textarea',
      'help' => 'Indiquez le réalisateur ou la réalisatrice, votre nom et votre fonction, ainsi que les membres de l’équipe montage et de la postproduction que vous souhaitez citer',
      'value' => get('team'),
      'rule' => ['required' => true],
      'error' => 'Merci de rensigner le champ'
    ],

    'blocks' => [
      'label' => 'Synopsis',
      'tag' => 'textarea',
      'value' => get('blocks'),
      'rule' => ['required' => true],
      'error' => 'Merci de rensigner le champ'
    ],

    'cover' => [
      'label' => 'Image',
      'type' => 'file',
      'accept' => 'image/*',
      'help' => 'Minimum 800 pixels de largeur au format JPG',
      'value' => $image['name'] ?? null
    ],

    'copyright' => [
      'label' => 'Copyright de l’image',
      'value' => get('copyright')
    ],

    'comment' => [
      'type' => 'textarea',
      'label' => 'Commentaire',
      'help' => 'Pour nous laisser un commentaire en cas de besoin',
      'value' => get('comment')
    ]
  ];

  // Check form
  $invalid = $kirby->request()->method() === 'POST' ? (function ($fields) {
    $data = [];
    $rules = [];
    $errors = [];
    foreach ($fields as $name => $field) {
      $data[$name] = $field['value'] ?? null;
      $rules[$name] = $field['rule'] ?? [];
      $errors[$name] = $field['error'] ?? null;
    }

    return invalid($data, $rules, $errors);
  })($fields) : null;

  // Upload
  if ($kirby->request()->method() === 'POST' && !$invalid) {
    try {
      $kirby->impersonate('kirby');

      // Avoid duplicates (including drafts)
      $parent = page('actualite-des-adherents');
      $baseSlug = Str::slug($fields['title']['value']);
      $slug = $baseSlug;
      $count = 2;
      while ($parent->childrenAndDrafts()->findBy('slug', $slug)) $slug = $baseSlug . '-' . $count++;

      $member = page('actualite-des-adherents')->createChild([
        'slug' => $slug,
        'template' => 'member',
        'content'  => [
          'showDate' => true,
          ...array_map(fn ($field) => $field['value'] ?? null, $fields)
        ]
      ]);

      if ($image && $image['error'] === 0) {
        $member->createFile([
          'source' => $image['tmp_name'],
          'filename' => F::safeName($image['name'])
        ]);
      }

      $kirby->email([
        'template' => 'submit-notification',
        'from' => 'no-reply@lma-asso.fr',
        'to' => 'actualite-des-adherent-es@lma-asso.fr',
        'subject' => '[Actualité des adhérent·es] Nouvelle actualité en attente de validation',
        'data' => ['page' => $member]
      ]);

      return snippet('components/Article', ['content' => $page->success()->kirbytext()]);
    } catch (Exception $error) {
      throw $error;
    }
  }
?>

<?php snippet('components/Article', slots: true) ?>
  <?php slot('content') ?>
    <form method='post' action='<?= $page->url() ?>' enctype='multipart/form-data'>
      <div class='field honey'>
        <label for='website'>Website</label>
        <input type='website' id='website' name='website' value='<?= esc(get('website') ?? '') ?>'>
        <input type='hidden' name='csrf' value='<?= csrf() ?>'>
      </div>

      <?php foreach ($fields as $name => $field) {
        echo Html::div([
          Html::label($field['label'] ?? $name, ['for' => $name]),
          Html::div($invalid[$name] ?? null, ['class' => 'error']),
          Html::tag(
            $field['tag'] ?? 'input',
            r($field['tag'] ?? null === 'textarea', esc($field['value'] ?? '')),
            [
              'id' => $name,
              'name' => $name,
              'required' => ($field['rule'] ?? [])['required'] ?? null,
              'readonly' => $field['readonly'] ?? false,
              'type' => $field['type'] ?? null,
              'value' => esc($field['value'] ?? ''),
              'accept' => $field['accept'] ?? null,
              'placeholder' => $field['placeholder'] ?? null
            ]
          ),
          Html::div($field['help'] ?? null, ['class' => 'help'])
        ], [
          'class' => [
            'field',
            r($invalid[$name] ?? null, 'has-error')
          ]
        ]);
      } ?>

      <input type='submit' name='submit' value='Soumettre'>
    </form>
  <?php endslot() ?>
<?php endsnippet() ?>
