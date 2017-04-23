<?php

  namespace Gambot\Components\IRC;
  use \Gambot\BaseMessage;
  
  class RawFreenodeParser extends \Gambot\Components\BaseComponent {
    public $botname;

    public function init($attributes) {
      $this->botname = $attributes['botname'] ?? 'phpGambot';
    }
    
    public function handleMessage(BaseMessage $message) {
      parent::handleMessage($message);

      $charactersNick = 'A-Za-z0-9[\]\\`_^{}|\-';
      $charactersUser = 'A-Za-z0-9[\]\\`_^{}|.\-';
      $charactersHost = ':.\/A-Za-z0-9[\]\\`_^{}|\-';
      $charactersChan = '#A-Za-z0-9[\]\\`_^{}|\-';
      $charactersServer = 'a-zA-Z0-9\.';
      $validNick = "([{$charactersNick}]+)";
      $validUser = "([{$charactersUser}]+)";
      $validHost = "([{$charactersHost}]+)";
      $validChan = "([{$charactersChan}]+|\\*)";
      $validChanStrict = "(#[{$charactersChan}]+)";
      $validSenderHuman = "{$validNick}!~?{$validUser}\@{$validHost}";
      $validSenderServer = "([{$charactersServer}]+)";

      // on_server_ping
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
      }

      // on_action
      elseif(preg_match("/^:$validSenderHuman (PRIVMSG) $validChan :ACTION (.*)$/", $message->body, $matches)) {
        $parsedMessage = new BaseMessage(['sender' => $this->name, 'tags' => [
          'sender_nick' => $matches[1],
          'sender_user' => $matches[2],
          'sender_host' => $matches[3],
          'receiver_nick' => '', // TODO: somehow get the bot's current name in here?
          'receiver_chan' => $matches[5],
          'command' => $matches[4],
          'message' => $matches[6],
          'event' => 'on_public_action'
        ]]);
        if($matches[5] === $this->botname) {
          $parsedMessage->tags['receiver_nick'] = $this->botname;
          $parsedMessage->tags['receiver_chan'] = $matches[1];
          $parsedMessage->tags['event'] = 'on_private_action';
        }
      }

      // on_ctcp
      elseif(preg_match("/^:$validSenderHuman (NOTICE|PRIVMSG) $validChan :(.+)$/", $message->body, $matches)) {
        $parsedMessage = new BaseMessage(['sender' => $this->name, 'tags' => [
          'sender_nick' => $matches[1],
          'sender_user' => $matches[2],
          'sender_host' => $matches[3],
          'receiver_nick' => '', // TODO: somehow get the bot's current name in here?
          'receiver_chan' => $matches[5],
          'command' => $matches[4],
          'message' => $matches[6],
          'event' => 'on_public_ctcp'
        ]]);
        if($matches[5] === $this->botname) {
          $parsedMessage->tags['receiver_nick'] = $this->botname;
          $parsedMessage->tags['receiver_chan'] = $matches[1];
          $parsedMessage->tags['event'] = 'on_private_action';
        }
      }

      // on_message
      elseif(preg_match("/^:$validSenderHuman (PRIVMSG) $validChan :(.*)$/", $message->body, $matches)) {
        $parsedMessage = new BaseMessage(['sender' => $this->name, 'tags' => [
          'sender_nick' => $matches[1],
          'sender_user' => $matches[2],
          'sender_host' => $matches[3],
          'receiver_nick' => '', // TODO: somehow get the bot's current name in here?
          'receiver_chan' => $matches[5],
          'command' => $matches[4],
          'message' => $matches[6],
          'event' => 'on_public_message'
        ]]);
        if($matches[5] === $this->botname) {
          $parsedMessage->tags['receiver_nick'] = $this->botname;
          $parsedMessage->tags['receiver_chan'] = $matches[1];
          $parsedMessage->tags['event'] = 'on_private_message';
        }
      }

      // on_notice
      elseif(preg_match("/^:$validSenderHuman (NOTICE) $validChan :(.+)$/", $message->body, $matches)) {
        $parsedMessage = new BaseMessage(['sender' => $this->name, 'tags' => [
          'sender_nick' => $matches[1],
          'sender_user' => $matches[2],
          'sender_host' => $matches[3],
          'receiver_nick' => '', // TODO: somehow get the bot's current name in here?
          'receiver_chan' => $matches[5],
          'command' => $matches[4],
          'message' => $matches[6],
          'event' => 'on_public_notice'
        ]]);
        if($matches[5] === $this->botname) {
          $parsedMessage->tags['receiver_nick'] = $this->botname;
          $parsedMessage->tags['receiver_chan'] = $matches[1];
          $parsedMessage->tags['event'] = 'on_private_notice';
        }
      }

      if(isset($parsedMessage)) {
        $this->spawnTags($parsedMessage);
        array_push($this->_message_queue, $parsedMessage);
      }

      return true;
    }
  }