<?php
  function GambotAutoloader($class) {
    require getcwd() . '/includes/' . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
  }

  spl_autoload_register('GambotAutoloader', true, true);

  use Gambot\IO\Child\{IRCServer, UDPListener, Terminal, Process};

  $children['server'] = new IRCServer();
  $children['terminal'] = new Terminal();
  $children['foobar'] = new Process(['command' => 'ls -l']);
  $children['udp'] = new UDPListener();

  

  $iterations_per_second = 10;

  while(usleep(1000000/$iterations_per_second) == null) {

    foreach($children as $name => $child) {
      if(($output = $child->getLines()) !== null) {
        foreach($output as $line) echo "[INCOMING] [{$name}]: {$line}\n";
      }
    }
  }