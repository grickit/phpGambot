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
    }

    public function matchTag($key, $value) {
      // fail if we don't have the key
      if(!isset($this->tags[$key]))
        return false;

      // succeed if they don't care about the value
      if($value === '*')
        return true;

      // succeed if the value matches
      if($this->tags[$key] === $value)
        return true;

      // fail by default
      return false;
    }

    public function addTag($key, $value, $overwrite = false) {
      // If not already set or if we are allowed to overwrite
      if(!isset($this->tags[$key]) || $overwrite === true)
        $this->tags[$key] = $value;
    }

    public function removeTag($key) {
      if(isset($this->tags[$key]))
        unset($this->tags[$key]);
    }
  }