<?php

  namespace Gambot\Components\Logging;
  use \Gambot\BaseMessage;
  
  class TerminalBasic extends \Gambot\Components\BaseComponent {
    
    public function handleMessage(BaseMessage $message) {
      parent::handleMessage($message);
      
      $time = gmdate('Y-m-d H:i:s');
      $microseconds = explode('.', microtime(true))[1];

      echo "[{$time} {$microseconds}] [{$message->sender}] {$message->body}\n";

      return true;      
    }
  }