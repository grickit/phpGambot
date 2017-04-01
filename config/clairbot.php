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
        'username' => 'clairebot2'
      ]
    ],

  
  ], // END CHILDREN

  'handlers' => [

  ], // END HANDLERS
];