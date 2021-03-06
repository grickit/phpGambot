<?php

  namespace Gambot\Components\IO;
  use \Gambot\Pipe;
  
  class Process extends \Gambot\Components\PipeComponent {
    private $_process;
    private $_pipes;

    public $command;
    public $directory;
    public $environment;

    public function init($attributes) {
      $this->command = $attributes['command'] ?? '';
      $this->directory = $attributes['directory'] ?? getcwd();
      $this->environment = $attributes['environment'] ?? [];

      $this->run();
    }

    private function run() {
      $this->_process = proc_open(
        $this->command,
        [
          ['pipe', 'r'], // stdin
          ['pipe', 'w'], // stdout
          ['pipe', 'w'], // stderr
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