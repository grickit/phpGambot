<?php

  namespace Gambot\IO\Child;
  use Gambot\IO\Child;
  use Gambot\IO\Pipe;

  class IRCServer extends Child {
    private $_connection;
    private $_error_number;
    private $_error_string;

    public $timeout;

    public $address;
    public $port;
    public $username;
    public $password;
    public $channel;

    public function init($attributes) {
      $this->address = $attributes['addresss'] ?? 'chat.freenode.net';
      $this->port = $attribtes['port'] ?? '6667';
      $this->username = $attributes['username'] ?? 'aPambot';
      $this->password = $attributes['password'] ?? null;
      $this->channel = $attributes['channel'] ?? '##Gambot';
      $this->timeout = $attributes['timeout'] ?? 20;

      $this->connect();
    }

    public function connect() {
      if($this->_connection === null) {
        $this->_connection = fsockopen(
          $this->address,
          $this->port,
          $this->error_number,
          $this->error_string,
          $this->timeout
        );

        $this->_pipe_messages = new Pipe($this->_connection);
        $this->_pipe_write = $this->_connection;

        if($this->password) $this->send("PASS {$this->username}:{$this->password}");
        $this->send("NICK {$this->username}");
        $this->send("USER Gambot P1 * : PHP Gambot");
        $this->send("JOIN :{$this->channel}");
      }
    }

    public function getErrors() {
      if($this->_error_number) return ["{$this->_error_number}: {$this->_error_string}"];

      return [];
    }
  }