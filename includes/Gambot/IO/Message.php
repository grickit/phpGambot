<?php

  namespace Gambot\IO;
  
  class Message {
    public $sender;
    public $body;
    public $type;
    public $tags;

    public function __construct($attributes = []) {
      $this->init($attributes);
    }

    public function init($attributes) {
      if(!isset($attributes['sender']))
        die('Message must have attribute "sender".');

      $this->sender = $attributes['sender'];
      $this->body = $attributes['body'] ?? '';
      $this->type = $attributes['type'] ?? 'message';
      $this->tags = $attributes['tags'] ?? [];

      // TODO: duh
      echo "[INCOMING] [{$this->sender}]: {$this->body}\n";
    }
  }