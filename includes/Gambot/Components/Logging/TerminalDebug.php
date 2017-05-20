<?php

  namespace Gambot\Components\Logging;
  use \Gambot\BaseMessage;
  
  class TerminalDebug extends \Gambot\Components\BaseComponent {
    
    public function handleMessage(BaseMessage $message) {
      parent::handleMessage($message);

      $message_json = json_encode($message, JSON_PRETTY_PRINT);
      
      $time = gmdate('Y-m-d H:i:s');
      $microseconds = explode('.', microtime(true))[1];

      echo "[{$time} {$microseconds}]\n{$message_json}\n\n";

      return true;      
    }
  }