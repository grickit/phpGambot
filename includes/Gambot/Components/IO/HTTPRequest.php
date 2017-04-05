<?php

  namespace Gambot\Components\IO;
  use \Gambot\Pipe;

  class HTTPRequest extends \Gambot\Components\PipeComponent {
    private $_request;
    private $_context;
    private $_content;

    public $address;
    public $transport;
    public $method;
    public $data;

    public function init($attributes) {
      $this->address = $attributes['address'] ?? 'http://google.com';
      $this->transport = $attributes['transport'] ?? 'http';
      $this->method = $attributes['method'] ?? 'GET';
      $this->data = $attributes['data'] ?? [];

      $this->run();
    }

    private function run() {
      $this->_context = stream_context_create([
        $this->transport => [
          'method' => $this->method
        ]
      ]);

      $this->_connection = fopen($this->address, 'r', false, $this->_context);

      $this->_pipe_messages = new Pipe($this->_connection);
      $this->_pipe_write = $this->_connection;
    }

    public function getErrors() {
      return [];
    }
  }