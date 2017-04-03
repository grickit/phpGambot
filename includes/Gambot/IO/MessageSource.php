<?php
  namespace Gambot\IO;

  abstract class MessageSource {
    protected $_message_queue = [];

    public function getMessages() {
      $messages = $this->_message_queue;
      $this->_message_queue = [];

      return $messages;
    }
  }