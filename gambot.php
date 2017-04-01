<?php
  function GambotAutoloader($class) {
    require getcwd() . '/includes/' . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
  }

  spl_autoload_register('GambotAutoloader', true, true);

  use Gambot\IO\Child\{IRCServer, UDPListener, Terminal, Process, HTTPRequest};

//  $children['server'] = new IRCServer();
//  $children['terminal'] = new Terminal();
//  $children['foobar'] = new Process(['command' => 'ls -l']);
//  $children['udp'] = new UDPListener();
//  $children['web'] = new HTTPRequest();

  $config = require getcwd() . '/config/clairbot.php';
  foreach($config['children'] as $name => $child) {
    if(!isset($child['class'])) continue;

    $attributes = $child['attributes'] ?? [];
    $children[$name] = new $child['class']($attributes);
  }

  $iterations_per_second = 10;

  $storage = new Gambot\Storage\Dictionary\FlatFile(['filename' => '/home/dhoagland/source/phpGambot/test.txt']);

  $children['STDIN']->send($storage->value_push('foobar',45));
  $children['STDIN']->send($storage->value_pull('foobar','33'));
  var_dump($storage->value_dump());
  $storage->save();

  while(usleep(1000000/$iterations_per_second) == null) {

    foreach($children as $name => $child) {
      if(($output = $child->getLines()) !== null) {
        foreach($output as $line) echo "[INCOMING] [{$name}]: {$line}\n";
      }
    }
  }