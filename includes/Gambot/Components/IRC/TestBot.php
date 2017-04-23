<?php

  namespace Gambot\Components\IRC;
  use \Gambot\BaseMessage;
  
  class TestBot extends \Gambot\Components\BaseComponent {
    
    public function handleMessage(BaseMessage $message) {
      parent::handleMessage($message);

      if($message->tags['event'] != 'on_server_message') {
        $responseMessage = new BaseMessage(['sender' => $this->name, 'body' => "PRIVMSG ##Gambot :{$message->tags['event']}"]);
        $this->spawnTags($responseMessage);
        array_push($this->_message_queue, $responseMessage);
      }
    }
  }