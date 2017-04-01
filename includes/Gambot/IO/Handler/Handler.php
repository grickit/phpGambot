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

    private function removeTags(&$message) {
      foreach($this->_tags_to_remove as $key => $value)
        $message->removeTag($key);
    }

    private function addTags(&$message) {
      foreach($this->_tags_to_add as $key => $value)
        $message->addTag($key, $value);
    }

    public function handleMessage(&$message) {
      $this->removeTags($message);
      $this->addTags($message);
    }

    public function matchMessage(Message &$message) {
      $matched = true;

      // TODO: actually implement matching
      foreach($this->_tags_to_receive as $key => $value) {
        
      }

      return $matched;
    }
  }