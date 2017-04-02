<?php

  namespace Gambot\IO\Handler;

  use Gambot\IO\Message;
  
  abstract class Handler {
    protected $_tags_to_receive;
    protected $_tags_to_add;
    protected $_tags_to_remove;

    public function __construct($attributes) {
      $this->_tags_to_receive = $attributes['tags_to_receive'] ?? [];
      $this->_tags_to_add = $attributes['tags_to_add'] ?? [];
      $this->_tags_to_remove = $attributes['tags_to_remove'] ?? [];
    }

    protected function removeTags($message) {
      foreach($this->_tags_to_remove as $key => $value)
        $message->removeTag($key);
    }

    protected function addTags($message) {
      foreach($this->_tags_to_add as $key => $value)
        $message->addTag($key, $value);
    }

    public function handleMessage($message) {
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