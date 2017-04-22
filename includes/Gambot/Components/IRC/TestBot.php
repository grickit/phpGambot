<?php

  namespace Gambot\Components\IRC;
  use \Gambot\BaseMessage;
  
  class TestBot extends \Gambot\Components\BaseComponent {
    
    public function handleMessage(BaseMessage $message) {
      parent::handleMessage($message);

      $responseMessage = new BaseMessage(['sender' => $this->name, 'body' => 'PRIVMSG ##Gambot :eat a dick']);
      $this->spawnTags($responseMessage);
      array_push($this->_message_queue, $responseMessage);
    }
  }