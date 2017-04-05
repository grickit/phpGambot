<?php

  namespace Gambot\IO\Handler;
  use Gambot\IO\Message;
  
  class Terminal extends \Gambot\IO\Component {
    
    public function handleMessage(Message $message) {
      parent::handleMessage($message);

      echo "[INCOMING] [{$message->sender}]: {$message->body}\n";

      if(rand(0,2) !== 2)
        return $message;
    }
  }