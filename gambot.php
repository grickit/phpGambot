<?php
  function GambotAutoloader($class) {
    require getcwd() . '/includes/' . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
  }

  spl_autoload_register('GambotAutoloader', true, true);

  use \Gambot\BaseMessage;


  // TODO: path to config needs to be a cli switch
  $config = require getcwd() . '/config/clairbot.php';

  // TODO: is this really the best place for this loading?
  foreach($config['components'] as $name => $component_config) {
    if(!isset($component_config['class'])) continue;

    if(!isset($component_config['name']))
      $component_config['name'] = $name;

    $component = new $component_config['class']($component_config);
    if($component->spawns_messages)
      $message_sources[$name] = $component;

    if($component->handles_messages)
      $message_receivers[$name] = $component;
    
    $components[$name] = $component;
  }

  $iterations_per_second = 10;

  $storage = new Gambot\Storage\Dictionary\FlatFile(['filename' => '/home/dhoagland/source/phpGambot/test.txt']);

  $components['STDIN']->send($storage->value_push('foobar',45));
  $components['STDIN']->send($storage->value_pull('foobar','33'));
  var_dump($storage->value_dump());
  $storage->save();

  // Main loop shouldn't take 100% CPU
  while(usleep(1000000/$iterations_per_second) == null) {

    // Poll our MessageSources for new messages
    foreach($message_sources as $name => $child) {

      // Iterate over all the messages
      foreach($child->getMessages() as $message) {

        // Check each receiver to see if they want it
        foreach($message_receivers as $handler_name => $handler) {

          // If they want it, give it to them
          if(($rulesetName = $handler->matchMessage($message)) !== false) {
            $return = $handler->handleMessage($rulesetName, $message);

            // Allow handlers to swallow messages
            if($return !== true) break;
          }
        }
      }
    }
  }