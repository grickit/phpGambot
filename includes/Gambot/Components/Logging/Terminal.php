<?php

  namespace Gambot\Components\Logging;
  use \Gambot\BaseMessage;
  
  class Terminal extends \Gambot\Components\BaseComponent {
    
    public function handleMessage($rulesetName, BaseMessage $message) {
      parent::handleMessage($rulesetName, $message);

      $message_json = json_encode($message);

      echo "[{$message->sender}]: {$message_json}\n";

      // Randomly swallow some messages by not returning true (just testing) TODO: remove this
      if(rand(0,2) !== 2)
        return true;
      
    }
  }