<?php

  namespace Gambot\Components\Logging;
  use \Gambot\BaseMessage;
  
  class Terminal extends \Gambot\Components\BaseComponent {
    
    public function handleMessage(BaseMessage $message) {
      parent::handleMessage($message);

      $message_json = json_encode($message);

      echo "[{$message->sender}]: {$message_json}\n";

      return true;      
    }
  }