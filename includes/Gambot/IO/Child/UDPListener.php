<?php

  namespace Gambot\IO\Child;
  use Gambot\IO\Pipe;

  class UDPListener extends Child {
    private $_connection;
    private $_pipe;
    private $_error_number;
    private $_error_string;

    public $address;
    public $port;

    public function __construct($attributes = []) {
      $this->address = $attributes['address'] ?? '127.0.0.1';
      $this->port = $attributes['port'] ?? '6891';

      $this->connect();
    }

    public function connect() {
      if($this->_connection === null) {
        $this->_connection = stream_socket_server(
          "udp://{$this->address}:{$this->port}",
          $this->_error_number,
          $this->_error_string,
          STREAM_SERVER_BIND
        );

        $this->_pipe_messages = new Pipe($this->_connection);
        $this->_pipe_write = $this->_connection;
      }
    }

    public function getErrors() {
      if($this->_error_number) return ["{$this->_error_number}: {$this->_error_string}"];

      return [];
    }
  }