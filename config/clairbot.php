<?php

return [
  'components' => [
    'STDIN' => [
      'class' => 'Gambot\Components\IO\Terminal',
      'spawns_messages' => true,
    ],

    'ls joke' => [
      'class' => 'Gambot\Components\IO\Process',
      'spawns_messages' => true,
      'command' => 'ls -l',
    ],

    'Freenode Connection' => [
      'class' => 'Gambot\Components\IO\IRCServer',
      'spawns_messages' => true,
      'username' => 'clairebot2',
      'tags_to_spawn' => [
        'irc' => 'raw',
        'network' => 'freenode',
        'bot' => 'clairbot2',
      ]
    ],

    'Freenode Connection 2' => [
      'class' => 'Gambot\Components\IO\IRCServer',
      'spawns_messages' => true,
      'username' => 'clairbot3',
      'tags_to_spawn' => [
        'irc' => 'raw',
        'network' => 'freenode',
        'bot' => 'clairbot3',
      ]
    ],

    'STDOUT' => [
      'class' => 'Gambot\Components\Logging\Terminal',
      'handles_messages' => true,
      'tags_to_receive' => [
        'irc' => 'raw',
        'bot' => 'clairbot3',
      ],
    ],

    'STDOUT2' => [
      'class' => 'Gambot\Components\Logging\Terminal',
      'handles_messages' => true,
      'tags_to_receive' => [
        'irc' => 'raw',
        'bot' => 'clairbot3',
      ],
    ]

  ]
];