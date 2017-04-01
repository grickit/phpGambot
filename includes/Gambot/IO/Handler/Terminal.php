<?php

  namespace Gambot\IO\Handler;
  
  class Terminal extends Handler {
    
    public function handleMessage(&$message) {
      parent::handleMessage($message);

      echo "[INCOMING] [{$message->sender}]: {$message->body}\n";
    }
  }