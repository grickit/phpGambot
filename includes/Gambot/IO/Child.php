<?php

  namespace Gambot\IO;
  use Gambot\IO\Message;
  
  abstract class Child extends MessageSource {
    protected $_pipe_messages;
    protected $_pipe_errors;
    protected $_pipe_write;
    protected $_tags_to_add;

    public function __construct($attributes = []) {
      if(!isset($attributes['name']))
        die('Child must have atrribute "name".');

      $this->name = $attributes['name'];
      $this->_tags_to_add = $attributes['tags_to_add'] ?? [];

      $this->init($attributes);
    }

    public function init($attributes) {

    }

    protected function getLines() {
      return $this->_pipe_messages->getLines();
    }

    protected function getErrors() {
      return $this->_pipe_errors->getLines();
    }

    public function send($message) {
      fwrite($this->_pipe_write, "{$message}\015\012");
    }

    protected function addTags(Message $message) {
      foreach($this->_tags_to_add as $key => $value) {
        $message->addTag($key, $value);
      }
    }

    public function getMessages() {
      foreach($this->getLines() as $line) {
        $message = new Message(['sender' => $this->name, 'body' => $line]);
        $this->addTags($message);
        array_push($this->_message_queue, $message);
      }

      foreach($this->getErrors() as $line) {
        $message = new Message(['sender' => $this->name, 'body' => $line, 'tags' => ['error' => TRUE]]);
        $this->addTags($message);
        array_push($this->_message_queue, $message);
      }

      return parent::getMessages();
    }
  }