<?php
  $data = [
    // WIP
    'token' => get('token')
  ];

  $fields = [
    'email' => [
      'label' => 'e-mail',
      'type' => 'email',
      'rule' => [
        'required' => true,
        'email' => true
      ],
      'error' => 'Merci d’entrer un e-mail valide'
    ],

    'token' => [
      'label' => 'clé de sécurité',
      'type' => 'text',
      'readonly' => isset($data['token']),
      'rule' => [
        'required' => true,
      ],
      'help' => 'La clé de sécurité vous a été communiqué par e-mail au moment de votre adhésion ou ré-adhésion',
      'error' => 'Clé de sécurité invalide'
    ],

    'title' => [
      'label' => 'titre',
      'type' => 'text',
      'rule' => [
        'required' => true,
      ],
      'error' => 'Merci d’entrer un titre'
    ],

    'diffusion' => [
      'label' => 'diffusion',
      'type' => 'text',
      'rule' => [
        'required' => true,
      ],
      'placeholder' => 'En salle, festival, chaîne de télévision, plateforme…',
      'error' => 'Merci d’indiquer les modalités de diffusion'
    ],

    'date' => [
      'type' => 'date',
      'help' => 'Date de la sortie ou de la diffusion',
      'rule' => [
        'required' => true,
      ],
      'error' => 'Merci d’entrer une date valide'
    ],

    'team' => [
      'label' => 'Équipe',
      'tag' => 'textarea',
      'help' => 'Indiquez le réalisateur ou la réalisatrice, votre nom et votre fonction, ainsi que les membres de l’équipe montage et de la postproduction que vous souhaitez citer',
      'rule' => [
        'required' => true,
      ]
    ],

    'synopsis' => [
      'tag' => 'textarea',
      'rule' => [
        'required' => true
      ]
    ],

    'image' => [
      'type' => 'file',
      'accept' => 'image/*',
      'help' => 'Minimum 800 pixels de largeur au format JPG'
    ],

    'copyright' => [
      'label' => 'Copyright de l’image'
    ],

    'comment' => [
      'type' => 'textarea',
      'label' => 'Commentaire',
      'help' => 'Pour nous laisser un commentaire en cas de besoin'
    ]
  ];
?>

<?php snippet('components/Header', [
  'title' => $page->title(),
  'content' => $page->description()->kirbytext()
]) ?>

<?php snippet('components/Article', slots: true) ?>
  <?php slot('content') ?>
    <form method='post' action='<?= $page->url() ?>' enctype='multipart/form-data'>
      <div class='field honey'>
        <label for='website'>Website</label>
        <input type='website' id='website' name='website' value='<?= $data['website'] ?? '' ?>'>
        <input type='hidden' name='csrf' value='<?= csrf() ?>'>
      </div>

      <?php foreach ($fields as $name => $field) {
        echo Html::div([
          Html::label($field['label'] ?? $name, ['for' => $name]),
          Html::tag(
            $field['tag'] ?? 'input',
            r($field['tag'] ?? null === 'textarea', esc($data[$name] ?? '')),
            [
              'id' => $name,
              'name' => $name,
              'required' => ($field['rule'] ?? [])['required'] ?? false,
              'readonly' => $field['readonly'] ?? false,
              'type' => $field['type'] ?? null,
              'value' => esc($data[$name] ?? '', 'attr'),
              'accept' => $field['accept'] ?? null,
              'placeholder' => $field['placeholder'] ?? null
            ]
          ),
          Html::div($field['help'] ?? null, ['class' => 'help'])
        ], ['class' => 'field']);
      } ?>

      <input type='submit' name='submit' value='Soumettre'>
    </form>
  <?php endslot() ?>
<?php endsnippet() ?>
