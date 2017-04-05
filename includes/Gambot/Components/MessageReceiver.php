<?php

  namespace Gambot\Components;
  use \Gambot\BaseMessage;

  abstract class MessageReceiver extends \Gambot\Components\MessageSource {
    protected $_tags_to_receive;
    protected $_tags_to_add;
    protected $_tags_to_remove;

    public function __construct($attributes) {
      parent::__construct($attributes);

      $this->_tags_to_receive = $attributes['tags_to_receive'] ?? [];
      $this->_tags_to_add = $attributes['tags_to_add'] ?? [];
      $this->_tags_to_remove = $attributes['tags_to_remove'] ?? [];
    }

    protected function removeTags(BaseMessage $message) {
      foreach($this->_tags_to_remove as $key => $value)
        $message->removeTag($key);
    }

    protected function addTags(BaseMessage $message) {
      foreach($this->_tags_to_add as $key => $value)
        $message->addTag($key, $value);
    }

    public function handleMessage(BaseMessage $message) {
      $this->removeTags($message);
      $this->addTags($message);

      return true;
    }

    public function matchMessage(BaseMessage $message) {
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