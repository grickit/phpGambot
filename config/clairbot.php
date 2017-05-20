<?php

return [
  'components' => [

    'STDIN' => [
      'class' => 'Gambot\Components\IO\Terminal',
      'spawns_messages' => true,
    ],

    /*
    'ls joke' => [
      'class' => 'Gambot\Components\IO\Process',
      'spawns_messages' => true,
      'command' => 'ls -l',
    ],
    */

    'Freenode Connection' => [
      'class' => 'Gambot\Components\IO\IRCServer',
      'spawns_messages' => true,
      'username' => 'clairebot2',
      'tags_to_spawn' => [
        'source' => 'irc',
        'parsed' => 'raw',
        'network' => 'freenode',
        'botname' => 'clairbot2',
      ],
      'handles_messages' => true,
      'rulesets' => [
        [
          ['\Gambot\Rules\ValueEqualsRule', 'destination', 'irc'],
        ]
      ]
    ],

    'Freenode Parser' => [
      'class' => 'Gambot\Components\IRC\RawFreenodeParser',
      'botname' => 'clairebot2',
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

    'AdvancedTerminalLogger' => [
      'class' => 'Gambot\Components\Logging\TerminalDebug',
      'handles_messages' => true,
      'rulesets' => [
        [
          ['\Gambot\Rules\KeyPresentRule', 'source', ''],
        ]
      ]
    ],

    'BasicTermianlLogger' => [
      'class' => 'Gambot\Components\Logging\TerminalBasic',
      'handles_messages' => true,
      'rulesets' => [
        [
          ['\Gambot\Rules\ValueEqualsRule', 'source', 'irc'],
          ['\Gambot\Rules\ValueEqualsRule', 'parsed', 'raw'],
        ],
        [
          ['\Gambot\Rules\ValueEqualsRule', 'destination', 'irc']
        ]
      ]
    ],

    'TESTBOT' => [
      'class' => 'Gambot\Components\IRC\TestBot',
      'spawns_messages' => true,
      'tags_to_spawn' => [
        'source' => 'giggles',
        'destination' => 'irc'
      ],
      'handles_messages' => true,
      'rulesets' => [
        [
          ['\Gambot\Rules\ValueEqualsRule', 'source', 'irc'],
          ['\Gambot\Rules\ValueEqualsRule', 'parsed', 'parsed'],
          ['\Gambot\Rules\ValueEqualsRule', 'network', 'freenode']
        ]
      ]
    ],

  ]
];