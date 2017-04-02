<?php

return [
  'children' => [
    'STDIN' => [
      'class' => 'Gambot\IO\Child\Terminal',
    ],

    'ls joke' => [
      'class' => 'Gambot\IO\Child\Process',
      'attributes' => [
        'command' => 'ls -l',
      ]
    ],

    'Freenode Connection' => [
      'class' => 'Gambot\IO\Child\IRCServer',
      'attributes' => [
        'username' => 'clairebot2',
        'tags_to_add' => [
          'irc' => 'raw',
          'network' => 'freenode',
          'bot' => 'clairbot2',
        ]
      ]
    ],

    'Freenode Connection 2' => [
      'class' => 'Gambot\IO\Child\IRCServer',
      'attributes' => [
        'username' => 'clairbot3',
        'tags_to_add' => [
          'irc' => 'raw',
          'network' => 'freenode',
          'bot' => 'clairbot3',
        ]
      ]
    ]

  
  ], // END CHILDREN

  'handlers' => [
    'STDOUT' => [
      'class' => 'Gambot\IO\Handler\Terminal',
      'attributes' => [
        'tags_to_receive' => [
          'irc' => 'raw',
          'bot' => 'clairbot3',
        ],
      ]
    ]
  ], // END HANDLERS
];