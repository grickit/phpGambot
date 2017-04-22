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
        'source' => 'irc',
        'parsed' => 'raw',
        'network' => 'freenode',
        'botname' => 'clairbot2',
      ]
    ],

    'Freenode Parser' => [
      'class' => 'Gambot\Components\IRC\RawFreenodeParser',
      'spawns_messages' => true,
      'handles_messages' => true,
      'tags_to_spawn' => [
        'source' => 'irc',
        'parsed' => 'parsed',
        'network' => 'freenode',
      ],
      'rulesets' => [
        [
          // TODO: aliases for the super common base rules?
          // '==' -> ValueEqualsRule,
          // '*' -> KeyPresentRule,
          // '%' -> ValueContainsRule
          // '>',
          // '>=',
          // '!=',
          // '<',
          // '<=',
          // 're' -> ValueRegexMatchRule,
          ['\Gambot\Rules\ValueEqualsRule', 'source', 'irc'],
          ['\Gambot\Rules\ValueEqualsRule', 'parsed', 'raw'],
          ['\Gambot\Rules\ValueEqualsRule', 'network', 'freenode']
        ]
      ]
    ],

    'STDOUT' => [
      'class' => 'Gambot\Components\Logging\Terminal',
      'handles_messages' => true,
      'rulesets' => [
        [
          ['\Gambot\Rules\KeyPresentRule', 'source', ''],
        ]
      ]
    ],

  ]
];