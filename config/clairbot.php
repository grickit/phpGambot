<?php

return [
  'components' => [
    'STDIN' => [
      'class' => 'Gambot\IO\Components\Terminal',
      'spawns_messages' => true,
    ],

    'ls joke' => [
      'class' => 'Gambot\IO\Components\Process',
      'spawns_messages' => true,
      'command' => 'ls -l',
    ],

    'Freenode Connection' => [
      'class' => 'Gambot\IO\Components\IRCServer',
      'spawns_messages' => true,
      'username' => 'clairebot2',
      'tags_to_spawn' => [
        'irc' => 'raw',
        'network' => 'freenode',
        'bot' => 'clairbot2',
      ]
    ],

    'Freenode Connection 2' => [
      'class' => 'Gambot\IO\Components\IRCServer',
      'spawns_messages' => true,
      'username' => 'clairbot3',
      'tags_to_spawn' => [
        'irc' => 'raw',
        'network' => 'freenode',
        'bot' => 'clairbot3',
      ]
    ],

    'STDOUT' => [
      'class' => 'Gambot\IO\Handler\Terminal',
      'handles_messages' => true,
      'tags_to_receive' => [
        'irc' => 'raw',
        'bot' => 'clairbot3',
      ],
    ],

    'STDOUT2' => [
      'class' => 'Gambot\IO\Handler\Terminal',
      'handles_messages' => true,
      'tags_to_receive' => [
        'irc' => 'raw',
        'bot' => 'clairbot3',
      ],
    ]

  ]
];