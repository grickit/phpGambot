<?php

  namespace Gambot\Components\Logging;
  use \Gambot\BaseMessage;
  
  class Terminal extends \Gambot\Components\BaseComponent {
    
    public function handleMessage(BaseMessage $message) {
      parent::handleMessage($message);

      echo "[INCOMING] [{$message->sender}]: {$message->body}\n";

      // Randomly swallow some messages by not returning true (just testing) TODO: remove this
      if(rand(0,2) !== 2)
        return true;
      
    }
  }