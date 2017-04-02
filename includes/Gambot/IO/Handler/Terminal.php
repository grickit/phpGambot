<?php

  namespace Gambot\IO\Handler;
  
  class Terminal extends Handler {
    
    public function handleMessage($message) {
      parent::handleMessage($message);

      echo "[INCOMING] [{$message->sender}]: {$message->body}\n";

      if(rand(0,2) !== 2)
        return $message;
    }
  }