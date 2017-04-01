<?php

  namespace Gambot\IO\Child;
  
  abstract class Child {
    protected $_pipe_messages;
    protected $_pipe_errors;
    protected $_pipe_write;
    protected $_tags_to_add;

    public function __construct($attributes = []) {
      $this->_tags_to_add = $attributes['tags_to_add'] ?? [];

      $this->init($attributes);
    }

    public function init($attributes) {

    }

    public function getLines() {
      return $this->_pipe_messages->getLines();
    }

    public function getErrors() {
      return $this->_pipe_errors->getLines();
    }

    public function send($message) {
      fwrite($this->_pipe_write, "{$message}\015\012");
    }

    private function addTags(&$message) {
      foreach($this->_tags_to_add as $key => $value) {
        $message->addTag($key, $value);
      }
    }

    public function handleMessage(&$message) {
      $this->addTags($message);
    }
  }