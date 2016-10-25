<?php

  namespace Gambot\IO\Child;
  use Gambot\IO\Pipe;
  
  class Process extends Child {
    private $_process;
    private $_pipes;

    public $command;
    public $directory;
    public $environment;

    public function __construct($attributes = []) {
      $this->command = $attributes['command'] ?? '';
      $this->directory = $attributes['directory'] ?? '/home/dhoagland/source/phpGambot/';
      $this->environment = $attributes['environment'] ?? [];

      $this->run();
    }

    private function run() {
      $this->_process = proc_open(
        $this->command,
        [
          ['pipe', 'r'], // stdin
          ['pipe', 'w'], // stdout
          ['pipe', 'w'], // stdout
        ],
        $this->_pipes,
        $this->directory,
        []
      );
      
      $this->_pipe_messages = new Pipe($this->_pipes[1]);
      $this->_pipe_errors = new Pipe($this->_pipes[2]);
      $this->_pipe_write = $this->_pipes[0];
    }
  }