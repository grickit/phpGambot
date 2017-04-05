<?php

  namespace Gambot\IO;
  use Gambot\IO\Message;
  
  abstract class PipeComponent extends \Gambot\IO\Component {
    protected $_pipe_messages;
    protected $_pipe_errors;
    protected $_pipe_write;
    protected $_tags_to_spawn;

    public function __construct($attributes = []) {
      parent::__construct($attributes);
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

    public function getMessages() {
      foreach($this->getLines() as $line) {
        $message = new Message(['sender' => $this->name, 'body' => $line]);
        $this->spawnTags($message);
        array_push($this->_message_queue, $message);
      }

      foreach($this->getErrors() as $line) {
        $message = new Message(['sender' => $this->name, 'body' => $line, 'tags' => ['error' => TRUE]]);
        $this->spawnTags($message);
        array_push($this->_message_queue, $message);
      }

      return parent::getMessages();
    }
  }