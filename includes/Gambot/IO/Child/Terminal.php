<?php

  namespace Gambot\IO\Child;
  use Gambot\IO\Child;
  use Gambot\IO\Pipe;
  
  class Terminal extends Child {

    public function init($attributes) {
      $this->_pipe_messages = new Pipe(STDIN);
      $this->_pipe_errors = new Pipe(STDERR);
    }
    
    public function send($message) {
      echo "{$message}\015\012";
    }
  }