<?php

  namespace Gambot\IO;
  use Gambot\IO\Message;
  
  abstract class Component extends \Gambot\IO\MessageReceiver {
    protected $_name;
    protected $_spawns_messages;
    protected $_handles_messages;

    public function __construct($attributes) {
      if(!isset($attributes['name']))
        die('Component must have atrribute "name".');
  
      $this->_name = $attributes['name'];
      parent::__construct($attributes);

      $this->_spawns_messages = $attributes['spawns_messages'] ?? false;
      $this->_handles_messages = $attributes['handles_messages'] ?? false;

      $this->init($attributes);
    }

    public function init($attributes) {

    }

    public function __get($name) {
      if($name === 'name')
        return $this->_name;

      if($name === 'spawns_messages')
        return $this->_spawns_messages;
      
      elseif($name === 'handles_messages')
        return $this->_handles_messages;

      else return null;
    }

    protected function removeTags(Message $message) {
      foreach($this->_tags_to_remove as $key => $value)
        $message->removeTag($key);
    }

    protected function addTags(Message $message) {
      foreach($this->_tags_to_add as $key => $value)
        $message->addTag($key, $value);
    }

    public function handleMessage(Message $message) {
      $this->removeTags($message);
      $this->addTags($message);
    }

    public function matchMessage(Message $message) {
      // shortcut if the handler is receiving all messages
      if(empty($this->_tags_to_receive))
        return true;

      foreach($this->_tags_to_receive as $key => $value) {
        if(!$message->matchTag($key, $value))
          return false;
      }

      return true;
    }
  }