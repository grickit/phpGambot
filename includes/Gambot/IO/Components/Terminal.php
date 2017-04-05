<?php

  namespace Gambot\IO\Components;
  use Gambot\IO\Pipe;
  
  class Terminal extends \Gambot\IO\PipeComponent {

    public function init($attributes) {
      $this->_pipe_messages = new Pipe(STDIN);
      $this->_pipe_errors = new Pipe(STDERR);
    }
    
    public function send($message) {
      echo "{$message}\015\012";
    }
  }