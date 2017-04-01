<?php

  namespace Gambot\IO\Child;
  
  abstract class Child {
    protected $_pipe_messages;
    protected $_pipe_errors;
    protected $_pipe_write;

    public function __construct($attributes = []) {
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
  }