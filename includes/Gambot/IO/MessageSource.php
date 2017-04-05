<?php
  namespace Gambot\IO;
  use Gambot\IO\Message;

  abstract class MessageSource {
    protected $_tags_to_spawn;
    protected $_message_queue = [];

    public function __construct($attributes) {
      $this->_tags_to_spawn = $attributes['tags_to_spawn'] ?? [];
    }

    protected function spawnTags(Message $message) {
      foreach($this->_tags_to_spawn as $key => $value) {
        $message->addTag($key, $value);
      }
    }

    public function getMessages() {
      $messages = $this->_message_queue;
      $this->_message_queue = [];

      return $messages;
    }

  }