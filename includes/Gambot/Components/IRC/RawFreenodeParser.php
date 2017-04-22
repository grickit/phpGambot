<?php

  namespace Gambot\Components\IRC;
  use \Gambot\BaseMessage;
  
  class RawFreenodeParser extends \Gambot\Components\BaseComponent {
    
    public function handleMessage(BaseMessage $message) {
      parent::handleMessage($message);

      $charactersNick = 'A-Za-z0-9[\]\\`_^{}|-';
      $charactersUser = 'A-Za-z0-9[\]\\`_^{}|.-';
      $charactersHost = ':./A-Za-z0-9[\]\\`_^{}|-';
      $charactersChan = '#A-Za-z0-9[\]\\`_^{}|-';
      $charactersServer = 'a-zA-Z0-9\.';
      $validNick = "([{$charactersNick}]+)";
      $validUser = "([{$charactersUser}]+)";
      $validHost = "([{$charactersHost}]+)";
      $validChan = "([{$charactersChan}]+|\\*)";
      $validChanStrict = "(#[{$charactersChan}]+)";
      $validSenderHuman = "{$validNick}!~?{$validUser}\@{$validHost}";
      $validSenderServer = "([${charactersServer}]+)";

      if(preg_match("/^(PING) :{$validSenderServer}$/i", $message->body, $matches)) {
        $parsedMessage = new BaseMessage(['sender' => $this->name, 'tags' => [
          'sender_nick' => $matches[2],
          'sender_user' => $matches[2],
          'sender_host' => $matches[2],
          'receiver_nick' => '', // TODO: somehow get the bot's current name in here?
          'receiver_chan' => '',
          'command' => $matches[1],
          'message' => '',
          'event' => 'on_server_ping'
        ]]);
        $this->spawnTags($parsedMessage);
        array_push($this->_message_queue, $parsedMessage);
      }
      
      return true;
    }
  }