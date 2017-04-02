<?php
  function GambotAutoloader($class) {
    require getcwd() . '/includes/' . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
  }

  spl_autoload_register('GambotAutoloader', true, true);

  use Gambot\IO\Message;


  // TODO: path to config needs to be a cli switch
  $config = require getcwd() . '/config/clairbot.php';

  // TODO: is this really the best place for this loading?
  foreach($config['children'] as $name => $child) {
    if(!isset($child['class'])) continue;

    $attributes = $child['attributes'] ?? [];
    $children[$name] = new $child['class']($attributes);
  }

  // TODO: is this really the best place for this loading?
  foreach($config['handlers'] as $name => $handler) {
    if(!isset($handler['class'])) continue;

    $attributes = $handler['attributes'] ?? [];
    $handlers[$name] = new $handler['class']($attributes);
  }

  $iterations_per_second = 10;

  $storage = new Gambot\Storage\Dictionary\FlatFile(['filename' => '/home/dhoagland/source/phpGambot/test.txt']);

  $children['STDIN']->send($storage->value_push('foobar',45));
  $children['STDIN']->send($storage->value_pull('foobar','33'));
  var_dump($storage->value_dump());
  $storage->save();

  while(usleep(1000000/$iterations_per_second) == null) {

    foreach($children as $child_name => $child) {
      if(($output = $child->getLines()) !== null) {
        foreach($output as $line) {
          $message = new Message(['sender' => $child_name, 'body' => $line]);
          $child->handleMessage($message);

          foreach($handlers as $handler_name => $handler) {
            if($handler->matchMessage($message))
              $handler->handleMessage($message);
          }
        }
      }
    }
  }